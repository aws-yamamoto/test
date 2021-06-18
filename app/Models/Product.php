<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Traits\DataOperation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    use DataOperation;

    protected $hidden = array('pivot');
    protected $cascadeDeletes = [
        'productItemStructures',
        'shopProducts'
    ];
    protected $dates = ['deleted_at'];

    /**
     * キャスト定義
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_category_id' => 'integer',
        'name' => 'string',
        'subname' => 'string',
        'short_description' => 'string',
        'long_description' => 'string',
        'unit' => 'string',
        'unit_disp' => 'string',
        'image' => 'string',
        'app_display_type' => 'integer',
        'valid_period_from' => 'date',
        'valid_period_to' => 'date',
        'edit_status' => 'string',
        'disp_type' => 'integer',
        'note' => 'string',
        'priority_order' => 'integer',
    ];

    /**
     * ホワイトリスト定義
     *
     * @var array
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'subname',
        'short_description',
        'long_description',
        'unit',
        'unit_disp',
        'image',
        'app_display_type',
        'valid_period_from',
        'valid_period_to',
        'edit_status',
        'disp_type',
        'note',
        'priority_order'
    ];

    /**
     * アクセサ定義
     *
     * @var array
     */
    protected $appends = [
        'image_name'
    ];

    /**
     * 商品に関連する店舗を取得
     *
     * @return void
     */
    public function shops()
    {
        return $this->belongsToMany('App\Models\Shop', 'shop_products', 'product_id', 'shop_id');
    }

    /**
     * 商品に関連する店舗_商品を取得
     *
     * @return void
     */
    public function shopProducts()
    {
        return $this->hasMany('App\Models\ShopProduct');
    }

    /**
     * 商品に関連する商品品目構成を取得
     *
     * @return void
     */
    public function productItemStructures()
    {
        return $this->hasMany('App\Models\ProductItemStructure');
    }

    /**
     * 商品に関連する商品カテゴリを取得
     *
     * @return void
     */
    public function productCategory()
    {
        return $this->belongsTo('App\Models\ProductCategory');
    }

    /**
     * S3にアップロードする画像名のアクセサ
     *
     * @return void
     */
    public function getImageNameAttribute()
    {
        return "product-id-$this->id";
    }
}
