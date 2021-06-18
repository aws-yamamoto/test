<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->string('name');
            $table->string('subname')->nullable();
            $table->integer('priority_order');
            $table->integer('select_type');
            $table->integer('select_qty_min')->nullable()->default(null);
            $table->integer('select_qty_max')->nullable()->default(null);
            $table->date('valid_period_from');
            $table->date('valid_period_to');
            $table->integer('app_display_type');
            $table->string('edit_status');
            $table->integer('disp_type');
            $table->boolean('delete_type')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::table('product_item_structures', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('product_item_structures');
    }
}
