<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 1, 1, null],
            [2, 1, 2, '2019-08-01 00:00:00'],
            [3, 1, 3, null],
            [4, 1, 4, null],
            [5, 1, 5, '2019-08-01 00:00:00'],
            [6, 1, 6, null],
            [7, 1, 7, '2019-08-01 00:00:00'],
            [8, 1, 8, null],
            [9, 1, 9, null],
            [10, 1, 10, null],
            [11, 1, 11, null],
            [12, 1, 12, null],
            [13, 1, 13, null],
            [14, 1, 14, null],
            [15, 1, 15, null],
            [16, 1, 16, null],
            [17, 1, 17, null],
            [18, 1, 18, null],
            [19, 1, 19, null],
            [20, 1, 20, null],
            [21, 1, 21, '2019-08-01 00:00:00'],
            [22, 1, 22, '2019-08-01 00:00:00'],
            [23, 1, 23, '2019-08-01 00:00:00'],
            [24, 1, 24, '2019-08-01 00:00:00'],
            [25, 1, 25, '2019-08-01 00:00:00'],
            [26, 1, 26, '2019-08-01 00:00:00'],
            [27, 1, 27, '2019-08-01 00:00:00'],
            [28, 1, 28, '2019-08-01 00:00:00'],
            [29, 1, 29, '2019-08-01 00:00:00'],
            [30, 1, 30, '2019-08-01 00:00:00'],
            [31, 2, 31, null],
            [32, 2, 32, null],
            [33, 2, 33, null],
            [34, 2, 34, '2019-08-01 00:00:00'],
            [35, 2, 35, null],
            [36, 2, 36, null],
            [37, 2, 37, null],
            [38, 2, 38, null],
        ];

        foreach ($records as $record) {
            DB::table('shop_products')->insert([
                'id' => $record[0],
                'shop_id' => $record[1],
                'product_id' => $record[2],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $record[3],
            ]);
        }
    }
}
