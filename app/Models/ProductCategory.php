<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Traits\DataOperation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCategory extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    use DataOperation;

    protected $hidden = array('pivot');
    protected $cascadeDeletes = [
        'productCategories',
        'products',
        'shopProductCategories',
        'infoItemPivots'
    ];
    protected $dates = ['deleted_at'];

    /**
     * キャスト定義
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'level' => 'integer',
        'parent_product_category_id' => 'integer',
        'name' => 'string',
        'subname' => 'string',
        'valid_period_from' => 'date',
        'valid_period_to' => 'date',
        'app_display_type' => 'integer',
        'edit_status' => 'string',
        'disp_type' => 'integer',
        'priority_order' => 'integer',
        'delete_type' => 'boolean'
    ];

    /**
     * ホワイトリスト定義
     */
    protected $fillable = [
        'level',
        'parent_product_category_id',
        'name',
        'subname',
        'valid_period_from',
        'valid_period_to',
        'app_display_type',
        'edit_status',
        'disp_type',
        'priority_order',
        'delete_type',
    ];

    /**
     * 商品カテゴリに関連する店舗を取得
     *
     * @return void
     */
    public function shops()
    {
        return $this->belongsToMany('App\Models\Shop', 'shop_product_categories', 'product_category_id', 'shop_id');
    }

    /**
     * 商品カテゴリに関連する店舗_商品カテゴリを取得
     *
     * @return void
     */
    public function shopProductCategories()
    {
        return $this->hasMany('App\Models\ShopProductCategory');
    }

    /**
     * 商品カテゴリに関連する商品を取得
     *
     * @return void
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * 商品カテゴリに関連する商品カテゴリを取得
     *
     * @return void
     */
    public function productCategories()
    {
        return $this->hasMany('App\Models\ProductCategory', 'parent_product_category_id', 'id');
    }

    /**
     * 商品カテゴリに関連する情報項目を取得
     *
     * @return void
     */
    public function infoItems()
    {
        // TODO
        return $this->belongsToMany('App\Models\InfoItem', 'info_item_pivots', 'product_category_id', 'info_item_id')->where('info_item_pivots.deleted_at', null);
    }

    /**
     * 商品カテゴリに関連する情報項目中間を取得
     *
     * @return void
     */
    public function infoItemPivots()
    {
        return $this->hasMany('App\Models\InfoItemPivot');
    }

    /**
     * 親商品カテゴリ取得スコープ
     *
     * @param $query
     * @return void
     */
    public function scopeTopCategory($query)
    {
        return $query->whereNull('parent_product_category_id');
    }

    /**
     * 子商品カテゴリ取得スコープ
     *
     * @param $query
     * @param int $parentId
     * @return void
     */
    public function scopeChildCategory($query, $parentId)
    {
        return $query->where('parent_product_category_id', $parentId);
    }

    /**
     * 特定の商品カテゴリ取得スコープ
     *
     * @param $query
     * @param int $productCategoryId
     * @return void
     */
    public function scopeProductCategory($query, $productCategoryId)
    {
        return $query->where('id', $productCategoryId);
    }

    /**
     * メニューの画像情報取得スコープ
     *
     * @param mixed $query
     * @param Integer $shopId
     * @param Date $verificationDate
     * @return void
     */
    public function scopeMenuInfoImages($query, $shopId, $verificationDate)
    {
        $day = null;
        $isVerificationDevice = false;

        if ($verificationDate) {
            $day = $verificationDate;
            $isVerificationDevice = true;
        } else {
            $day = Carbon::now()->format('Y-m-d');
        }

        $activeIds = $this->fetchActiveIds($shopId, $day, $isVerificationDevice);

        // 有効な商品ID
        $activeProductIds = $activeIds['activeProductIds'];
        // 有効な商品品目ID
        $activeProductItemIds = $activeIds['activeProductItemIds'];

        $productImages = DB::table('products')->whereIn('id', $activeProductIds)->where('image', '<>', '')->get('image');
        $productItemImages = DB::table('product_items')
                                ->leftJoin('items', 'product_items.item_id', '=', 'items.id')
                                ->whereIn('product_items.id', $activeProductItemIds)
                                ->where('items.image', '<>', '')
                                ->get('items.image');
        
        $productImagesArr = [];
        $productItemImagesArr = [];

        foreach ($productImages->toArray() as $productImage) {
            $productImagesArr[] = collect($productImage)['image'];
        }

        foreach ($productItemImages->toArray() as $productItemImage) {
            $productItemImagesArr[] = collect($productItemImage)['image'];
        }

        return array_merge($productImagesArr, $productItemImagesArr);
    }

    /**
     * メニュー情報取得スコープ
     *
     * @param $query
     * @param Integer $shopId
     * @param Date $verificationDate
     * @return void
     */
    public function scopeMenuInfo($query, $shopId, $verificationDate)
    {
        $day = null;
        $isVerificationDevice = false;

        if ($verificationDate) {
            $day = $verificationDate;
            $isVerificationDevice = true;
        } else {
            $day = Carbon::now()->format('Y-m-d');
        }

        $activeIds = $this->fetchActiveIds($shopId, $day, $isVerificationDevice);

        // 有効なトップカテゴリID
        $activeParentProductCategoryIds = $activeIds['activeParentProductCategoryIds'];
        // 有効な商品カテゴリID
        $activeProductCategoryIds = $activeIds['activeProductCategoryIds'];
        // 有効な商品ID
        $activeProductIds = $activeIds['activeProductIds'];
        // 有効な商品構成ID
        $activeProductItemStructureIds = $activeIds['activeProductItemStructureIds'];
        // 有効な商品品目ID
        $activeProductItemIds = $activeIds['activeProductItemIds'];
        // 有効な商品品目数量ID
        $activeProductItemQuantityIds = $activeIds['activeProductItemQuantityIds'];

        return $query->whereIn('product_categories.id', $activeParentProductCategoryIds)
            ->with(['productCategories' =>
            function ($q) use ($activeProductCategoryIds, $activeProductIds, $activeProductItemStructureIds, $activeProductItemIds, $activeProductItemQuantityIds) {
                $q->select(
                    'id',
                    'name',
                    'subname',
                    'parent_product_category_id'
                )
                ->whereIn('id', $activeProductCategoryIds)
                ->with(['infoItems' => function ($q) {
                    $q->select(
                        'image'
                    );
                }])
                ->with(['products' =>
                function ($q) use ($activeProductIds, $activeProductItemStructureIds, $activeProductItemIds, $activeProductItemQuantityIds) {
                    $q->select(
                        'id',
                        'name',
                        'subname',
                        'unit',
                        'long_description',
                        'image',
                        'short_description',
                        'app_display_type',
                        'product_category_id'
                    )
                    ->whereIn('id', $activeProductIds)
                    ->orderBy('priority_order', 'asc')
                    ->with(['productItemStructures' =>
                    function ($q) use ($activeProductItemStructureIds, $activeProductItemIds, $activeProductItemQuantityIds) {
                        $q->select(
                            'id',
                            'name',
                            'subname',
                            'select_type',
                            'select_qty_min',
                            'select_qty_max',
                            'product_id'
                        )
                        ->whereIn('id', $activeProductItemStructureIds)
                        ->with(['infoItems' => function ($q) {
                            $q->select(
                                'image'
                            );
                        }])
                        ->with(['productItems' =>
                        function ($q) use ($activeProductItemIds, $activeProductItemQuantityIds) {
                            $q->leftJoin('items', 'product_items.item_id', '=', 'items.id')
                            ->select(
                                'product_items.id',
                                'items.name',
                                'items.image',
                                'product_items.quty_selected_type',
                                'product_items.product_item_structure_id'
                            )
                            ->whereIn('product_items.id', $activeProductItemIds)
                            ->with(['productItemQuantities' =>
                            function ($q) use ($activeProductItemQuantityIds) {
                                $q->leftJoin('product_items', 'product_item_quantities.product_item_id', '=', 'product_items.id')
                                ->leftJoin('items', 'product_items.item_id', '=', 'items.id')
                                ->select(
                                    'product_item_quantities.id',
                                    'product_item_quantities.fixed_value_name',
                                    'product_item_quantities.fixed_value',
                                    'items.unit',
                                    'product_item_quantities.display_unit',
                                    'product_item_quantities.change_value_range',
                                    'product_item_quantities.change_value_default',
                                    'product_item_quantities.change_value_min',
                                    'product_item_quantities.change_value_max',
                                    'product_item_quantities.cost',
                                    'product_item_quantities.selling_price',
                                    'product_item_quantities.energy',
                                    'product_item_quantities.protein',
                                    'product_item_quantities.fat',
                                    'product_item_quantities.carbohydrate',
                                    'product_item_quantities.salt_equivalent',
                                    'product_item_quantities.product_item_id'
                                )
                                ->whereIn('product_item_quantities.id', $activeProductItemQuantityIds);
                            }]);
                        }]);
                    }]);
                }]);
            }]);
    }

    /**
     * メニュー情報取得に必要な商品カテゴリ、商品、商品構成、商品品目、商品品目数量のIDを取得
     *
     * @param mixed $query
     * @param Integer $shopId
     * @param String $day
     * @param Boolean $isVerificationDevice
     * @return Array
     */
    public function scopeFetchActiveIds($query, $shopId, $day, $isVerificationDevice)
    {
        // 有効なトップカテゴリIDを取得
        $activeParentProductCategoryIds = $this->fetchActiveParentProductCategories($shopId, $day, $isVerificationDevice)
            ->pluck('product_categories.id');

        // 有効な商品カテゴリ、商品、商品構成、商品品目、商品品目数量を取得
        $activeMenus = $this->fetchActiveMenus($shopId, $day, $isVerificationDevice)
            ->get([
                'product_categories.id as product_category_id',
                'products.id as product_id',
                'product_item_structures.id as product_item_structure_id',
                'product_items.id as product_item_id',
                'product_item_quantities.id as product_item_quantity_id',
            ]);

        // 有効な商品カテゴリ、商品、商品構成、商品品目、商品品目数量のIDを取得する
        $activeProductCategoryIds = [];
        $activeProductIds = [];
        $activeProductItemStructureIds = [];
        $activeProductItemIds = [];
        $activeProductItemQuantityIds = [];

        foreach ($activeMenus as $activeMenu) {
            $activeProductCategoryIds[] = $activeMenu['product_category_id'];
            $activeProductIds[] = $activeMenu['product_id'];
            $activeProductItemStructureIds[] = $activeMenu['product_item_structure_id'];
            $activeProductItemIds[] = $activeMenu['product_item_id'];
            $activeProductItemQuantityIds[] = $activeMenu['product_item_quantity_id'];
        }

        return [
            'activeParentProductCategoryIds' => $activeParentProductCategoryIds,
            'activeProductCategoryIds' => $activeProductCategoryIds,
            'activeProductIds' => $activeProductIds,
            'activeProductItemStructureIds' => $activeProductItemStructureIds,
            'activeProductItemIds' => $activeProductItemIds,
            'activeProductItemQuantityIds' => $activeProductItemQuantityIds
        ];
    }

    /**
     * 有効なトップカテゴリーを取得
     *
     * @param mixed $query
     * @param Integer $shopId
     * @param String $day
     * @param Boolean $isVerificationDevice
     * @return void
     */
    public function scopeFetchActiveParentProductCategories($query, $shopId, $day, $isVerificationDevice)
    {
        $query_ = $query->whereHas('shops', function ($q) use ($shopId) {
            $q->where('shops.id', $shopId);
        })
        ->where('product_categories.valid_period_from', '<=', $day)
        ->where('product_categories.valid_period_to', '>=', $day)
        ->where('product_categories.edit_status', config('flagDefinition.EDIT_STATUS.FINISH'))
        ->whereNull('parent_product_category_id');

        if ($isVerificationDevice) {
            $query_ = $query_
                        ->where('product_categories.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'))
                        ->orWhere('product_categories.disp_type', config('flagDefinition.DISP_TYPE.PRE'));
        } else {
            $query_ = $query_
                        ->where('product_categories.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'));
        }

        return $query_;
    }

    /**
     * 有効な商品カテゴリ、商品、商品構成、商品品目、商品品目数量を取得
     *
     * @param mixed $query
     * @param Integer $shopId
     * @param String $day
     * @param Boolean $isVerificationDevice
     * @return void
     */
    public function scopeFetchActiveMenus($query, $shopId, $day, $isVerificationDevice)
    {
        $query_ =  $query->join('shop_product_categories', 'product_categories.id', '=', 'shop_product_categories.product_category_id')
                    ->leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
                    ->leftJoin('product_item_structures', 'products.id', '=', 'product_item_structures.product_id')
                    ->leftJoin('product_items', 'product_item_structures.id', '=', 'product_items.product_item_structure_id')
                    ->leftJoin('product_item_quantities', 'product_items.id', '=', 'product_item_quantities.product_item_id')
                    ->where('shop_product_categories.shop_id', '=', $shopId)
                    ->where('product_categories.valid_period_from', '<=', $day)
                    ->where('product_categories.valid_period_to', '>=', $day)
                    ->where('products.valid_period_from', '<=', $day)
                    ->where('products.valid_period_to', '>=', $day)
                    ->where('product_item_structures.valid_period_from', '<=', $day)
                    ->where('product_item_structures.valid_period_to', '>=', $day)
                    ->where('product_items.valid_period_from', '<=', $day)
                    ->where('product_items.valid_period_to', '>=', $day)
                    // TODO: 在庫取得の時に削除済みレコードも返ってきてしまう
                    ->where('product_categories.deleted_at', null)
                    ->where('products.deleted_at', null)
                    ->where('product_item_structures.deleted_at', null)
                    ->where('product_items.deleted_at', null)
                    ->where('product_categories.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'))
                    ->where('products.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'))
                    ->where('product_item_structures.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'))
                    ->where('product_items.disp_type', config('flagDefinition.DISP_TYPE.DISPLAY'));

        if ($isVerificationDevice) {
            $query_ = $query_
                        ->orWhere('product_categories.disp_type', config('flagDefinition.DISP_TYPE.PRE'))
                        ->orWhere('products.disp_type', config('flagDefinition.DISP_TYPE.PRE'))
                        ->orWhere('product_item_structures.disp_type', config('flagDefinition.DISP_TYPE.PRE'))
                        ->orWhere('product_items.disp_type', config('flagDefinition.DISP_TYPE.PRE'));
        }

        return $query_;
    }

    /**
     * レコード数をカウントするスコープ
     *
     * @param mixed $query
     * @param Integer $shopId
     * @param Integer $parentProductCategoryId
     * @return void
     */
    public function scopeRecordCount($query, $shopId, $parentProductCategoryId = null)
    {
        $query = $query->whereHas('shops', function ($q) use ($shopId) {
            $q->where('shops.id', $shopId);
        })
        ->where('parent_product_category_id', $parentProductCategoryId)
        ->get();

        return count($query);
    }
}
