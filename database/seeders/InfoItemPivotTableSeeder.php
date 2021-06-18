<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InfoItemPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 10, null, 3, null, 0],
            [2, 12, null, 3, null, 0],
            [3, 11, null, 3, null, 0],
            [4, 5, null, 11, null, 0],
            [5, 2, null, 11, null, 0],
            [6, 4, null, 11, null, 0],
            [7, 7, null, 11, null, 0],
            [8, 1, null, 11, null, 0],
            [9, 9, null, 11, null, 0],
            [10, 8, null, 11, null, 0],
            [11, 6, null, 11, null, 0],
        ];

        foreach ($records as $record) {
            DB::table('info_item_pivots')->insert([
                'id' => $record[0],
                'info_item_id' => $record[1],
                'shop_id' => $record[2],
                'product_category_id' => $record[3],
                'product_item_structure_id' => $record[4],
                'disp_order' => $record[5],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
