<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\InfoItemPivot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCategoryRepository
{
    protected $productCategory;
    protected $infoItemPivot;
    protected $product;

    /**
    * ProductCategoryRepository constructor.
    * @param App\Models\ProductCategory $product_category
    * @param App\Models\InfoItemPivot $info_item_pivot
    * @param App\Models\Product $product_model
    */
    public function __construct(
        ProductCategory $product_category,
        InfoItemPivot $info_item_pivot,
        Product $product_model
    ) {
        $this->productCategory = $product_category;
        $this->infoItemPivot = $info_item_pivot;
        $this->product = $product_model;
    }

    /**
     * メニューの画像URL取得処理
     *
     * @param int $shopId
     * @param string $verificationDate
     * @return array
     */
    public function fetchMenuImages($shopId, $verificationDate)
    {
        return $this->productCategory->menuInfoImages($shopId, $verificationDate);
    }

    /**
     * メニュー情報全件取得処理
     *
     * @param int $shopId
     * @param string $verificationDate
     * @return object
     */
    public function fetchMenus($shopId, $verificationDate)
    {
        return $this->productCategory->menuInfo($shopId, $verificationDate)->get(['product_categories.id', 'product_categories.name']);
    }

    /**
     * トップカテゴリ取得処理
     *
     * @param int $shopId 店舗ID
     * @param string $searchValidPeriodFrom
     * @param string $searchValidPeriodTo
     * @return object
     */
    public function fetchTopCategories($shopId, $searchKeyword, $searchValidPeriodFrom, $searchValidPeriodTo)
    {
        $query = $this->productCategory->topCategory()
                    ->orderBy('priority_order', 'asc')
                    ->join('shop_product_categories', 'product_categories.id', '=', 'shop_product_categories.product_category_id')
                    ->where('shop_product_categories.shop_id', '=', $shopId)
                    ->where(function ($query) use ($searchKeyword) {
                        $query->where('name', 'LIKE', "%$searchKeyword%")
                            ->orWhere('subname', 'LIKE', "%$searchKeyword%");
                    });

        if ($searchValidPeriodFrom !== 'null' && $searchValidPeriodFrom) {
            $query = $query->where('product_categories.valid_period_to', '>=', $searchValidPeriodFrom);
        }

        if ($searchValidPeriodTo !== 'null' && $searchValidPeriodTo) {
            $query = $query->where('product_categories.valid_period_from', '<=', $searchValidPeriodTo);
        }

        return $query->paginate(20);
    }

    /**
     * トップカテゴリに紐づく子カテゴリのみ取得処理
     *
     * @param int $shopId 店舗ID
     * @param int $id トップカテゴリID
     * @param string $searchValidPeriodFrom
     * @param string $searchValidPeriodTo
     * @return object
     */
    public function fetchChildCategory($shopId, $id, $searchKeyword, $searchValidPeriodFrom, $searchValidPeriodTo)
    {
        $query = $this->productCategory->childCategory($id)
                    ->orderBy('priority_order', 'asc')
                    ->join('shop_product_categories', 'product_categories.id', '=', 'shop_product_categories.product_category_id')
                    ->where('shop_product_categories.shop_id', '=', $shopId)
                    ->where(function ($query) use ($searchKeyword) {
                        $query->where('name', 'LIKE', "%$searchKeyword%")
                            ->orWhere('subname', 'LIKE', "%$searchKeyword%");
                    });

        if ($searchValidPeriodFrom !== 'null' && $searchValidPeriodFrom) {
            $query = $query->where('product_categories.valid_period_to', '>=', $searchValidPeriodFrom);
        }

        if ($searchValidPeriodTo !== 'null' && $searchValidPeriodTo) {
            $query = $query->where('product_categories.valid_period_from', '<=', $searchValidPeriodTo);
        }

        return $query->paginate(20);
    }

    /**
     * 1件取得処理
     *
     * @param int $id
     * @return object
     */
    public function fetchShow($id)
    {
        return $this->productCategory->with('infoItems')->findOrFail($id);
    }

    /**
     * トップ商品カテゴリ一覧取得処理
     *
     * @param int $shopId
     * @return object
     */
    public function fetchTopCategoryList($shopId)
    {
        return $this->productCategory->whereHas('shops', function ($query) use ($shopId) {
            $query->where('shops.id', $shopId);
        })
        ->whereNull('parent_product_category_id')
        ->get(['product_categories.id', 'product_categories.name']);
    }

    /**
     * 子商品カテゴリ一覧取得処理
     *
     * @param int $shopId
     * @return object
     */
    public function fetchChildCategoryList($shopId)
    {
        return $this->productCategory->whereHas('shops', function ($query) use ($shopId) {
            $query->where('shops.id', $shopId);
        })
        ->whereNotNull('parent_product_category_id')
        ->get(['product_categories.id', 'product_categories.name']);
    }

    /**
     * 新規登録処理
     *
     * @param Illuminate\Http\Request $request
     * @param int $shopId
     * @return object
     */
    public function createRecord($request, $shopId)
    {
        if (!$request['parent_product_category_id']) {
            // トップカテゴリの場合
            $request['level'] = 1;
        } else {
            // 商品カテゴリの場合
            $request['level'] = 2;
        }

        $request->valid_period_from = Carbon::parse($request->valid_period_from)->format('Y-m-d');
        $request->valid_period_to = Carbon::parse($request->valid_period_to)->format('Y-m-d');

        DB::beginTransaction();
        try {
            $record = new $this->productCategory;
            $record->fill($request->all())->save();
            $record->shops()->attach($request->shop_id);

            foreach ($request['info_items'] as $infoItem) {
                $infoItemPivotRecord = new $this->infoItemPivot;
                $infoItemPivotRecord->info_item_id = $infoItem['id'];
                $infoItemPivotRecord->product_category_id = $record->id;
                $infoItemPivotRecord->save();
            }

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
        DB::beginTransaction();
        try {
            $record = $this->productCategory->findOrFail($id);

            $request->valid_period_from = Carbon::parse($request->valid_period_from)->format('Y-m-d');
            $request->valid_period_to = Carbon::parse($request->valid_period_to)->format('Y-m-d');

            $record->fill($request->all())->save();

            foreach ($request['info_items'] as $infoItem) {
                $this->infoItemPivot->updateOrCreate(
                    [
                        'info_item_id' => $infoItem['id'],
                        'product_category_id' => $record->id,
                    ],
                    [
                        'info_item_id' => $infoItem['id'],
                        'product_category_id' => $record->id,
                    ]
                );
            }
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
     * 削除処理
     *
     * @param int $id
     * @return object
     */
    public function deleteRecord($id)
    {
        DB::beginTransaction();
        try {
            $shopId = DB::table('shop_product_categories')->where('product_category_id', $id)->value('shop_id');
            $record = $this->productCategory->findOrFail($id);
            $parentProductCategoryId = $record->parent_product_category_id;
            $priorityOrder = $record->priority_order;

            // 削除するレコードより優先順位が低いレコードを取得
            $afterPriorityRecords = $this->productCategory->whereHas('shops', function ($query) use ($shopId) {
                $query->where('shops.id', $shopId);
            })
            ->where('parent_product_category_id', $parentProductCategoryId)
            ->where('priority_order', '>', $priorityOrder)
            ->get();

            // 削除するレコードより優先順位が大きいレコードの優先順位を上げる
            foreach ($afterPriorityRecords as $afterPriorityRecord) {
                $afterPriorityRecord->priority_order = $afterPriorityRecord->priority_order - 1;
                $afterPriorityRecord->save();
            }

            $record->delete();

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
     * 優先順更新処理
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function updatePriorityOrder($request)
    {
        return $this->productCategory->updatePriorityOrderData($request);
    }
}
