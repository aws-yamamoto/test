<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Traits\DataOperation;

class ProductItemStructure extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    use DataOperation;

    protected $hidden = array('pivot');
    protected $cascadeDeletes = [
        'productItems',
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
        'product_id' => 'integer',
        'name' => 'string',
        'subname' => 'string',
        'priority_order' => 'integer',
        'select_type' => 'integer',
        'select_qty_min' => 'integer',
        'select_qty_max' => 'integer',
        'valid_period_from' => 'date',
        'valid_period_to' => 'date',
        'app_display_type' => 'integer',
        'edit_status' => 'string',
        'disp_type' => 'integer',
        'delete_type' => 'boolean'
    ];

    /**
     * ホワイトリスト定義
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name',
        'subname',
        'priority_order',
        'select_type',
        'select_qty_min',
        'select_qty_max',
        'valid_period_from',
        'valid_period_to',
        'app_display_type',
        'edit_status',
        'disp_type',
        'delete_type'
    ];

    /**
     * 商品品目構成に関連する商品品目を取得
     *
     * @return void
     */
    public function productItems()
    {
        return $this->hasMany('App\Models\ProductItem');
    }

    /**
     * 商品品目構成に関連する商品を取得
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * 商品品目構成に関連する情報項目を取得
     *
     * @return void
     */
    public function infoItems()
    {
        return $this->belongsToMany('App\Models\InfoItem', 'info_item_pivots', 'product_item_structure_id', 'info_item_id');
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
