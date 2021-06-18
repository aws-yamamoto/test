<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DataOperation;

class InfoItem extends Model
{
    use SoftDeletes;
    use DataOperation;

    protected $hidden = array('pivot');

    /**
     * キャスト定義
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'info_item_name' => 'string',
        'image' => 'string'
    ];

    /**
     * ホワイトリスト定義
     *
     * @var array
     */
    protected $fillable = [
        'info_item_name',
        'image'
    ];

    /**
     * 情報項目に関連する商品カテゴリを取得
     *
     * @return void
     */
    public function productCategory()
    {
        return $this->belongsToMany('App\Models\ProductCategory', 'info_item_pivots', 'info_item_id', 'product_category_id');
    }

    /**
     * 情報項目に関連する店舗を取得
     *
     * @return void
     */
    public function shop()
    {
        return $this->belongsToMany('App\Models\Shop', 'info_item_pivots', 'info_item_id', 'shop_id');
    }

    /**
     * 情報項目に関連する商品品目構成を取得
     *
     * @return void
     */
    public function productItemStructure()
    {
        return $this->belongsToMany('App\Models\ProductItemStructure', 'info_item_pivots', 'info_item_id', 'product_item_structure_id');
    }
}
