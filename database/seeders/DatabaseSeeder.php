<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductItemStructureTableSeeder::class);
        $this->call(ShopProductTableSeeder::class);
        $this->call(ShopProductCategoryTableSeeder::class);
        $this->call(InfoItemTableSeeder::class);
        $this->call(InfoItemPivotTableSeeder::class);
    }
}
