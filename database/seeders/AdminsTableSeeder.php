<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'テスト管理者', 'admin@test.com', null, 12345678],
        ];

        foreach ($records as $record) {
            $id = $record[0];
            $exists = DB::table('admins')->where('id', $id)->exists();
            if (! $exists) {
                DB::table('admins')->insert([
                    'id' => $id,
                    'name' => encrypt($record[1]),
                    'email' => encrypt($record[2]),
                    'email_verified_at' => $record[3],
                    'password' => bcrypt($record[4]),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
