<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductItemStructureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 1, 'RICE', 'ごはん', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [2, 1, 'MAIN', '主菜', 2, 2, 1, 5, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [3, 1, 'MRS', 'ミールリプレースメントシェイク', 3, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [4, 1, 'BOOSTER', 'ブースター', 4, 2, 0, 14, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [5, 1, 'PP＋MRSベース', 'PP＋MRSベース', 5, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [6, 2, 'RICE', 'ごはん', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [7, 2, 'MAIN', '主菜', 2, 2, 1, 5, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [8, 2, 'DRINK', 'ドリンク', 3, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [9, 2, 'PP＋ドリンクベース', 'PP＋ドリンクベース', 4, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [10, 3, 'SAURCE', 'ソース', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [11, 3, 'NOODLE', '生パスタ', 2, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [12, 3, 'MAIN', '主菜', 3, 2, 0, 4, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [13, 3, 'OPTIONS', 'オプション', 4, 2, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [14, 3, 'パワーパスタベース', 'パワーパスタベース', 5, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [15, 4, 'SAUCE', 'ソース', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [16, 4, 'NOODLE', '生パスタ', 2, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [17, 4, 'MAIN', '主菜', 3, 2, 1, 4, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [18, 4, 'OPTIONS', 'オプション', 4, 2, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [19, 4, 'MRS', 'ミールリプレースメントシェイク', 5, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [20, 4, 'BOOSTER', 'ブースター', 6, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [21, 4, 'パスタ＋MRSベース', 'パスタ＋MRSベース', 7, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [22, 5, 'SAUCE', 'ソース', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [23, 5, 'NOODLE', 'パスタ', 2, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [24, 5, 'MAIN', '主菜', 3, 2, 1, 4, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [25, 5, 'OPTIONS', 'オプション', 4, 2, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [26, 5, 'DRINK', 'ドリンク', 5, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [27, 5, 'パスタ＋ドリンクベース', 'パスタ＋ドリンクベース', 6, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [28, 6, 'MAIN', '主菜', 1, 2, 1, 4, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [29, 6, 'MRS', 'ミールリプレースメントシェイク', 2, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [30, 6, 'BOOSTER', 'ブースター', 3, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [31, 6, 'サラダ＋MRベース', 'サラダ＋MRベース', 4, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [32, 7, 'MAIN', '主菜', 1, 2, 1, 4, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [33, 7, 'DRINK', 'ドリンク', 2, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [34, 7, 'サラダ＋ドリンクベース', 'サラダ＋ドリンクベース', 3, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [35, 8, '16穀米ベース', '16穀米ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [36, 9, 'コンニャク米ベース', 'コンニャク米ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [37, 10, 'パワーベーグルベース', 'パワーベーグルベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [38, 11, 'パワーベーグル(限定)ベース', 'パワーベーグル(限定)ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [39, 12, 'カスタマイズMRSベース', 'カスタマイズMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [40, 12, 'FRUITS', 'フルーツ', 2, 2, 0, 2, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [41, 12, 'JUICE', 'ジュース', 3, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [42, 12, 'OPTION', 'オプション', 4, 2, 0, 3, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [43, 12, 'BOOSTER', 'ブースター', 5, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [44, 13, 'ハチミツレモンMRSベース', 'ハチミツレモンMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [45, 13, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [46, 14, 'ストロベリーMRSベース', 'ストロベリーMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [47, 14, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [48, 15, 'アップルMRSベース', 'アップルMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [49, 15, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [50, 16, 'オレンジMRSベース', 'オレンジMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [51, 16, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [52, 17, 'ホウレンソウMRSベース', 'ホウレンソウMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [53, 17, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [54, 18, 'バナナセーキMRSベース', 'バナナセーキMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [55, 18, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [56, 19, 'モロヘイヤMRSベース', 'モロヘイヤMRSベース', 1, 1, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [57, 19, 'BOOSTER', 'ブースター', 2, 2, 0, 13, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [58, 20, 'PROTEIN', 'プロテイン', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [59, 20, 'BOOSTER', 'ブースター', 2, 2, 0, 8, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [60, 21, '100% オレンジベース', '100% オレンジベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [61, 22, '100% アップルベース', '100% アップルベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [62, 23, '100% グレープフルーツベース', '100% グレープフルーツベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [63, 24, 'ホットコーヒーベース', 'ホットコーヒーベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [64, 25, 'アイスコーヒーベース', 'アイスコーヒーベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [65, 26, 'ホットココアベース', 'ホットココアベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [66, 27, 'アイスココアベース', 'アイスココアベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [67, 28, 'ホット黒ウーロン茶ベース', 'ホット黒ウーロン茶ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [68, 29, 'アイス黒ウーロン茶ベース', 'アイス黒ウーロン茶ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [69, 30, 'ホットティーベース', 'ホットティーベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [70, 31, 'ONE PLATE LUNCH', 'ワンプレートランチ', 1, 2, 1, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [71, 32, '特性ハンバーグステーキベース', '特性ハンバーグステーキベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [72, 33, '近の鶏卵　ふわとろオムライスベース', '近の鶏卵　ふわとろオムライスベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [73, 34, 'ローストビーフ丼ベース', 'ローストビーフ丼ベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, '2019-08-01 00:00:00'],
            [74, 35, 'ビーフカレーベース', 'ビーフカレーベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
            [75, 36, 'カツカレーベース', 'カツカレーベース', 1, 1, 0, 1, '2019-07-01', '2020-07-01', 1, 1, 1, false, null],
        ];

        foreach ($records as $record) {
            DB::table('product_item_structures')->insert([
                'id' => $record[0],
                'product_id' => $record[1],
                'name' => $record[2],
                'subname' => $record[3],
                'priority_order' => $record[4],
                'select_type' => $record[5],
                'select_qty_min' => $record[6],
                'select_qty_max' => $record[7],
                'valid_period_from' => $record[8],
                'valid_period_to' => $record[9],
                'app_display_type' => $record[10],
                'edit_status' => $record[11],
                'disp_type' => $record[12],
                'delete_type' => $record[13],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $record[14],
            ]);
        }
    }
}
