<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('product_category_id')->unsigned();
            $table->boolean('delete_type')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('shop_id');
            $table->index('product_category_id');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade');

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_product_categories', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['product_category_id']);
        });
        Schema::dropIfExists('shop_product_categories');
    }
}
