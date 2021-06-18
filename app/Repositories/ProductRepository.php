<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductItemStructure;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    protected $product;
    protected $productCategory;
    protected $productItemStructure;

    /**
     * ProductRepository constructor.
     * @param App\Models\Product $product
     * @param App\Models\ProductCategory $product_category
     * @param App\Models\ProductItemStructure $product_item_structure
     */
    public function __construct(
        Product $product_model,
        ProductCategory $product_category,
        ProductItemStructure $product_item_structure
    ) {
        $this->product = $product_model;
        $this->productCategory = $product_category;
        $this->productItemStructure = $product_item_structure;
    }

    /**
     * 全件取得処理
     *
     * @param integer $shopId
     * @param string $searchKeyword
     * @param integer $topProductCategoryId
     * @param integer $productCategoryId
     * @param string $searchValidPeriodFrom
     * @param string $searchValidPeriodTo
     * @return object
     */
    public function fetchIndex($shopId, $searchKeyword, $topProductCategoryId, $productCategoryId, $searchValidPeriodFrom, $searchValidPeriodTo)
    {
        $query = $this->product
                    ->join('shop_products', 'products.id', '=', 'shop_products.product_id')
                    ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                    ->select(
                        'products.id',
                        'products.name',
                        'products.subname',
                        'products.image',
                        'products.disp_type',
                        'products.edit_status',
                        'product_categories.id as product_category_id',
                        'product_categories.name as product_category_name',
                        'products.valid_period_from',
                        'products.valid_period_to',
                        'products.note',
                        'products.priority_order'
                    )
                    ->where('shop_products.shop_id', '=', $shopId)
                    ->where(function ($q) use ($searchKeyword) {
                        $q->where('products.name', 'LIKE', "%$searchKeyword%");
                    });

        // クエリパラメータの値のため文字列で比較

        if ($productCategoryId !== 'null' && $productCategoryId) {
            $query = $query->where('product_category_id', $productCategoryId);
        }

        if ($searchValidPeriodFrom !== 'null' && $searchValidPeriodFrom) {
            $query = $query->where('products.valid_period_to', '>=', $searchValidPeriodFrom);
        }

        if ($searchValidPeriodTo !== 'null' && $searchValidPeriodTo) {
            $query = $query->where('products.valid_period_from', '<=', $searchValidPeriodTo);
        }

        if ($shopId == 2) {
            return $query->orderBy('products.priority_order', 'asc')
                ->paginate(20);
        } else {
            return $query->orderBy('product_category_name', 'asc')
                ->orderBy('products.priority_order', 'asc')
                ->paginate(20);
        }
    }

    /**
     * 1件取得処理
     *
     * @param int $id
     * @return object
     */
    public function fetchShow($id)
    {
        return $this->product->with('productItemStructures')->findOrFail($id);
    }

    /**
     * リストを取得
     *
     * @return array
     */
    public function fetchList()
    {
        return $this->product->get(['id', 'name']);
    }

    /**
     * 新規登録処理
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function createRecord($request)
    {
        $request->valid_period_from = Carbon::parse($request->valid_period_from)->format('Y-m-d');
        $request->valid_period_to = Carbon::parse($request->valid_period_to)->format('Y-m-d');
        DB::beginTransaction();
        try {
            $record = new $this->product;
            $record->fill($request->all())->save();
            $record->shops()->attach($request->shop_id);

            DB::commit();
            return response($record, 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    /**
     * 更新処理
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return object
     */
    public function updateRecord($request, $id)
    {
        $request->valid_period_from = Carbon::parse($request->valid_period_from)->format('Y-m-d');
        $request->valid_period_to = Carbon::parse($request->valid_period_to)->format('Y-m-d');
        return $this->product->updateData($request, $id);
    }

    /**
     * 削除処理
     *
     * @param int $id
     * @return object
     */
    public function deleteRecord($id)
    {
        DB::beginTransaction();
        try {
            $record = $this->product->findOrFail($id);
            $record->delete();

            // detach() を使用すると物理削除されるため、deleted_atを更新する
            DB::table('shop_products')
                ->where('product_id', $id)
                ->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);

            DB::commit();
            return $record;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    /**
     * レコードの最後のID取得
     *
     * @return int
     */
    public function fetchLastId()
    {
        return $this->product->orderBy('id', 'desc')->value('id');
    }

    public function createCopy($id)
    {
        DB::beginTransaction();
        try {
            $productRecord = new $this->product;
            $copyRecord = $this->product->with('shops')->findOrFail($id);
            $copyRecord->edit_status = config('flagDefinition.EDIT_STATUS.EDITING');
            $copyRecord->note = 'コピーによる作成';
            $productRecord->fill($copyRecord->toArray())->save();
            $productRecord->shops()->attach($copyRecord->shops[0]->id);

            $productItemStructures = $this->productItemStructure->where('product_id', $copyRecord->id)->get();
            foreach ($productItemStructures->toArray() as $productItemStructure) {
                $productItemStructureRecord = new $this->productItemStructure;
                $productItemStructure['product_id'] = $productRecord->id;
                $productItemStructureRecord->fill($productItemStructure)->save();

                $productItems = $this->productItem->where('product_item_structure_id', $productItemStructure['id'])->get();
                foreach ($productItems->toArray() as $productItem) {
                    $productItemRecord = new $this->productItem;
                    $productItem['product_item_structure_id'] = $productItemStructureRecord->id;
                    $productItemRecord->fill($productItem)->save();

                    $productItemQuantities = $this->productItemQuantity->where('product_item_id', $productItem['id'])->get();
                    foreach ($productItemQuantities->toArray() as $productItemQuantity) {
                        $productItemQuantityRecord = new $this->productItemQuantity;
                        $productItemQuantity['product_item_id'] = $productItemRecord->id;
                        $productItemQuantityRecord->fill($productItemQuantity)->save();
                    }
                }
            }
            DB::commit();
            return response($productRecord, 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }
}
