<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 1, null, 'FOOD', 'FOOD', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [2, 2, 1, 'POWER PLATE', 'パワープレート', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [3, 2, 1, 'POWER NOODLE PASTA', 'パワーヌードルパスタ', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, null],
            [4, 2, 1, 'POWER SALAD', 'パワーサラダ', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, null],
            [5, 1, null, 'SIDE', 'SIDE', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, null],
            [6, 2, 5, 'SIDE', 'サイド', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [7, 2, 5, 'RICE(SIDE)', 'ごはん(単品)', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, null],
            [8, 2, 5, 'BAGLE', 'ベーグル', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, '2019-08-01 00:00:00'],
            [9, 1, null, 'MRS', 'MRS', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, null],
            [10, 2, 9, 'SPECIAL', 'スペシャル', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [11, 2, 9, 'BASE', 'BASE', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, null],
            [12, 2, 9, 'SUPPLEMENT', 'サプリメント', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, null],
            [13, 1, null, 'DRINK', 'DRINK', '2019-07-01', '2040-07-01', 1, 1, 1, 4, false, '2019-08-01 00:00:00'],
            [14, 2, 13, '100% JUICE', '100% ジュース', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, '2019-08-01 00:00:00'],
            [15, 2, 13, 'COFFEE', 'コーヒー', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, '2019-08-01 00:00:00'],
            [16, 2, 13, 'COCOA', 'ココア', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, '2019-08-01 00:00:00'],
            [17, 2, 13, 'BLACK OOLONG', '黒ウーロン茶', '2019-07-01', '2040-07-01', 1, 1, 1, 4, false, '2019-08-01 00:00:00'],
            [18, 2, 13, 'TEA', '紅茶', '2019-07-01', '2040-07-01', 1, 1, 1, 5, false, '2019-08-01 00:00:00'],
            [19, 1, null, 'FOOD', 'FOOD', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [20, 2, 19, 'ONE PLATE LUNCH', 'ワンプレートランチ', '2019-07-01', '2040-07-01', 1, 1, 1, 1, false, null],
            [21, 2, 19, 'GRILL', 'グリル', '2019-07-01', '2040-07-01', 1, 1, 1, 2, false, null],
            [22, 2, 19, 'KINDAI ORIGINAL', '近大オリジナル', '2019-07-01', '2040-07-01', 1, 1, 1, 3, false, null],
            [23, 2, 19, 'DON', '丼物', '2019-07-01', '2040-07-01', 1, 1, 1, 4, false, null],
            [24, 2, 19, 'CURRY', 'カレー', '2019-07-01', '2040-07-01', 1, 1, 1, 5, false, null],
            [25, 2, 19, 'PICNIC SET', 'ピクニックセット', '2019-07-01', '2040-07-01', 1, 1, 1, 6, false, null],
        ];

        foreach ($records as $record) {
            DB::table('product_categories')->insert([
                'id' => $record[0],
                'level' => $record[1],
                'parent_product_category_id' => $record[2],
                'name' => $record[3],
                'subname' => $record[4],
                'valid_period_from' => $record[5],
                'valid_period_to' => $record[6],
                'app_display_type' => $record[7],
                'edit_status' => $record[8],
                'disp_type' => $record[9],
                'priority_order' => $record[10],
                'delete_type' => $record[11],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $record[12],
            ]);
        }
    }
}
