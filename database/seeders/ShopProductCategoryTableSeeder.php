<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 1, 1, false, null],
            [2, 1, 2, false, null],
            [3, 1, 3, false, null],
            [4, 1, 4, false, null],
            [5, 1, 5, false, null],
            [6, 1, 6, false, null],
            [7, 1, 7, false, null],
            [8, 1, 8, false, null],
            [9, 1, 9, false, null],
            [10, 1, 10, false, '2019-08-01 00:00:00'],
            [11, 1, 11, false, '2019-08-01 00:00:00'],
            [12, 1, 12, false, null],
            [13, 1, 13, false, '2019-08-01 00:00:00'],
            [14, 1, 14, false, '2019-08-01 00:00:00'],
            [15, 1, 15, false, '2019-08-01 00:00:00'],
            [16, 1, 16, false, '2019-08-01 00:00:00'],
            [17, 1, 17, false, '2019-08-01 00:00:00'],
            [18, 1, 18, false, '2019-08-01 00:00:00'],
            [19, 2, 19, false, null],
            [20, 2, 20, false, null],
            [21, 2, 21, false, null],
            [22, 2, 22, false, null],
            [23, 2, 23, false, null],
            [24, 2, 24, false, null],
            [25, 2, 25, false, null],
        ];

        foreach ($records as $record) {
            DB::table('shop_product_categories')->insert([
                'id' => $record[0],
                'shop_id' => $record[1],
                'product_category_id' => $record[2],
                'delete_type' => $record[3],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $record[4],
            ]);
        }
    }
}
