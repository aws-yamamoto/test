<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Traits\DataOperation;

class Shop extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    use DataOperation;

    protected $hidden = array('pivot');
    protected $cascadeDeletes = ['infoItemPivots'];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'shop_name' => 'string',
        'disp_type' => 'integer',
        'delete_type' => 'boolean'
    ];
    protected $fillable = [
        'shop_name',
        'disp_type',
        'delete_type'
    ];

    /**
     * 店舗に関連する商品カテゴリを取得
     *
     * @return void
     */
    public function productCategories()
    {
        return $this->belongsToMany('App\Models\ProductCategory', 'shop_product_categories', 'shop_id', 'product_category_id');
    }

    /**
     * 店舗に関連する商品を取得
     *
     * @return void
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'shop_products', 'shop_id', 'product_id');
    }

    /**
     * 店舗に関連する情報項目を取得
     *
     * @return void
     */
    public function infoItems()
    {
        return $this->belongsToMany('App\Models\InfoItem', 'info_item_pivots', 'shop_id', 'info_item_id');
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
}
