<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VersionManagement extends Model
{
    use SoftDeletes;

    /**
     * キャスト定義
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'version' => 'integer'
    ];

    /**
     * ホワイトリスト定義
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'version'
    ];
}
