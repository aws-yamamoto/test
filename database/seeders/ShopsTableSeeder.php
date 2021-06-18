<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'カフェ', 1, '06-1111-1111', false],
            [2, '食堂', 2, '06-2222-2222', false],
        ];

        foreach ($records as $record) {
            DB::table('shops')->insert([
                'id' => $record[0],
                'shop_name' => $record[1],
                'disp_type' => $record[2],
                'tel' => $record[3],
                'delete_type' => $record[4],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
