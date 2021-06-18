<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InfoItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'MSR バナナセーキ', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-1.jpeg'],
            [2, 'MSR キウイスパーク', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-2.jpeg'],
            [3, 'オーガニックコーヒー', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-3.jpeg'],
            [4, 'MRS パイナップル', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-4.jpeg'],
            [5, 'MRS ストロベリー', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-5.jpeg'],
            [6, 'MRS トロピカルアップル', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-6.jpeg'],
            [7, 'MRS トロピカルモロヘイヤ', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-7.jpeg'],
            [8, 'MRS トロピカルオレンジ', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-8.jpeg'],
            [9, 'MRS トロピカルホウレンソウ', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-9.jpeg'],
            [10, 'パワーパスタ', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-10.jpeg'],
            [11, 'パワーパスタ トマトソース', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-11.jpeg'],
            [12, 'パワーパスタ ホワイトクリーム', 'https://s3-ap-northeast-1.amazonaws.com/s3-kindai-service-cafe-upload/info_items/info-item-id-12.jpeg']
        ];

        foreach ($records as $record) {
            DB::table('info_items')->insert([
                'id' => $record[0],
                'info_item_name' => $record[1],
                'image' => $record[2],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
