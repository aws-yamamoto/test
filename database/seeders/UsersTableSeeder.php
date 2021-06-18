<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [1, 'adminuser', 'admin@test.com', null, 12345678]
        ];

        foreach ($records as $record) {
            DB::table('users')->insert([
                'id' => $record[0],
                'name' => $record[1],
                'email' => $record[2],
                'email_verified_at' => $record[3],
                'password' => bcrypt($record[4]),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
