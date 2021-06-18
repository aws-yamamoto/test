<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 2, 'PP＋MRS', 'PP＋MRS', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-1.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [2, 2, 'PP＋ドリンク', 'PP＋ドリンク', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-2.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [3, 3, 'パワーパスタ', 'パワーパスタ', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-3.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [4, 3, 'パスタ＋MRS', 'パスタ＋MRS', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-4.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [5, 3, 'パスタ＋ドリンク', 'パスタ＋ドリンク', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-5.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [6, 4, 'サラダ＋MRS', 'サラダ＋MRS', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-6.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [7, 4, 'サラダ＋ドリンク', 'サラダ＋ドリンク', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-7.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [8, 7, '16穀米', '16穀米', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-8.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [9, 7, 'コンニャク米', 'コンニャク米', '', '', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-9.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [10, 8, 'パワーベーグル', 'パワーベーグル', '', '', '個', '個', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-10.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [11, 8, 'パワーベーグル(限定)', 'パワーベーグル(限定)', '', '', '個', '個', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-11.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [12, 10, 'カスタマイズMRS', 'カスタマイズMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-12.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [13, 11, 'ハチミツレモンMRS', 'ハチミツレモンMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-13.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [14, 11, 'ストロベリーMRS', 'ストロベリーMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-14.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [15, 11, 'アップルMRS', 'アップルMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-15.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [16, 11, 'オレンジMRS', 'オレンジMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-16.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [17, 11, 'ホウレンソウMRS', 'ホウレンソウMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-17.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [18, 11, 'バナナセーキMRS', 'バナナセーキMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-18.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [19, 11, 'モロヘイヤMRS', 'モロヘイヤMRS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-19.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [20, 12, 'DNS', 'DNS', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-20.png', 2, '2019-07-01', '2020-07-01', 1, 1, null],
            [21, 14, '100% オレンジ', '100% オレンジ', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-21.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [22, 14, '100% アップル', '100% アップル', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-22.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [23, 14, '100% グレープフルーツ', '100% グレープフルーツ', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-23.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [24, 15, 'ホットコーヒー', 'ホットコーヒー', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-24.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [25, 15, 'アイスコーヒー', 'アイスコーヒー', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-25.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [26, 16, 'ホットココア', 'ホットココア', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-26.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [27, 16, 'アイスココア', 'アイスココア', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-27.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [28, 17, 'ホット黒ウーロン茶', 'ホット黒ウーロン茶', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-28.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [29, 17, 'アイス黒ウーロン茶', 'アイス黒ウーロン茶', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-29.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [30, 18, 'ホットティー', 'ホットティー', '', '', '杯', '杯', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-30.png', 2, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [31, 20, 'ONE PLATE LUNCH', 'ONE PLATE LUNCH', 'ライス、デザート付き', '¥450~', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-31.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [32, 21, '特製ハンバーグステーキ150g', '特製ハンバーグステーキ150g', 'ライス、デザート付き', '¥650', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-32.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [33, 22, '近の鶏卵ふわとろオムライス（スープ付）', '近の鶏卵ふわとろオムライス（スープ付）', '', '¥500', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-33.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [34, 23, 'ローストビーフ丼', 'ローストビーフ丼', '', '¥800', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-34.png', 1, '2019-07-01', '2020-07-01', 1, 1, '2019-08-01 00:00:00'],
            [35, 24, 'ビーフカレー', 'ビーフカレー', '', '¥350', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-35.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [36, 24, 'カツカレー', 'カツカレー', '', '¥430', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-36.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [37, 24, '2種類の炙りチーズ　カレー', '2種類の炙りチーズ　カレー', '', '¥430', '皿', '皿', 'https://s3-aws-yamamoto.s3.ap-northeast-3.amazonaws.com/products/product-id-37.png', 1, '2019-07-01', '2020-07-01', 1, 1, null],
            [38, 25, 'バーガー・唐揚・ポテトetc', 'バーガー・唐揚・ポテトetc', '', '¥1500', '皿', '皿', '', 1, '2019-07-01', '2020-07-01', 1, 1, null],
        ];

        foreach ($records as $record) {
            DB::table('products')->insert([
                'id' => $record[0],
                'product_category_id' => $record[1],
                'name' => $record[2],
                'subname' => $record[3],
                'short_description' => $record[4],
                'long_description' => $record[5],
                'unit' => $record[6],
                'unit_disp' => $record[7],
                'image' => $record[8],
                'app_display_type' => $record[9],
                'valid_period_from' => $record[10],
                'valid_period_to' => $record[11],
                'edit_status' => $record[12],
                'disp_type' => $record[13],
                'priority_order' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $record[14],
            ]);
        }
    }
}
