<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoItemPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_item_pivots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('info_item_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->bigInteger('product_category_id')->unsigned()->nullable();
            $table->bigInteger('product_item_structure_id')->unsigned()->nullable();
            $table->integer('disp_order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('info_item_id')
                ->references('id')
                ->on('info_items')
                ->onDelete('cascade');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade');

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');

            $table->foreign('product_item_structure_id')
                ->references('id')
                ->on('product_item_structures')
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
        Schema::table('info_item_pivots', function (Blueprint $table) {
            $table->dropForeign(['product_item_structure_id']);
            $table->dropForeign(['product_category_id']);
            $table->dropForeign(['shop_id']);
        });
        Schema::dropIfExists('info_item_pivots');
    }
}
