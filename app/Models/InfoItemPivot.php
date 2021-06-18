<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DataOperation;

class InfoItemPivot extends Model
{
    use SoftDeletes;
    use DataOperation;

    /**
     * キャスト定義
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'info_item_id' => 'integer',
        'shop_id' => 'integer',
        'product_category_id' => 'integer',
        'product_item_structure_id' => 'integer',
        'disp_order' => 'integer'
    ];

    /**
     * ホワイトリスト定義
     *
     * @var array
     */
    protected $fillable = [
        'info_item_id',
        'shop_id',
        'product_category_id',
        'product_item_structure_id',
        'disp_order'
    ];

    /**
     * アクセサ定義
     *
     * @var array
     */
    protected $appends = [
        'shop_name',
        'product_category_name',
        'product_item_structure_name'
    ];

    /**
     * 店舗名取得アクセサ
     *
     * @return string
     */
    public function getStoreNameAttribute()
    {
        $shopModel = Shop::class;
        $shop = new $shopModel;

        return $shop->where('id', $this->shop_id)->value('shop_name');
    }

    /**
     * 商品カテゴリ名取得アクセサ
     *
     * @return string
     */
    public function getProductCategoryNameAttribute()
    {
        $productCategoryModel = ProductCategory::class;
        $productCategory = new $productCategoryModel;

        return $productCategory->where('id', $this->product_category_id)->value('name');
    }

    /**
     * 商品品目構成取得アクセサ
     *
     * @return string
     */
    public function getProductItemStructureNameAttribute()
    {
        $productItemStructureModel = ProductItemStructure::class;
        $productItemStructure = new $productItemStructureModel;
        $productItemStructureName = $productItemStructure->where('id', $this->product_item_structure_id)->value('name');
        $productId = $productItemStructure->where('id', $this->product_item_structure_id)->value('product_id');

        $productModel = Product::class;
        $product = new $productModel;
        $productName = $product->where('id', $productId)->value('name');
        $productCategoryId = $product->where('id', $productId)->value('product_category_id');


        $productCategoryModel = ProductCategory::class;
        $productCategory = new $productCategoryModel;
        $productCategoryName = $productCategory->where('id', $productCategoryId)->value('name');

        return "$productCategoryName $productName $productItemStructureName";
    }
}
