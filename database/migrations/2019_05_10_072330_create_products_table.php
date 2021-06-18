<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_category_id')->unsigned();
            $table->string('name');
            $table->string('subname')->nullable();
            $table->string('short_description')->nullable();
            $table->string('long_description')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_disp')->nullable();
            $table->longText('image')->nullable();
            $table->integer('app_display_type');
            $table->date('valid_period_from');
            $table->date('valid_period_to');
            $table->string('edit_status')->nullable();
            $table->integer('disp_type')->nullable();
            $table->string('note')->nullable();
            $table->integer('priority_order');
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_category_id');

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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);
        });
        Schema::dropIfExists('products');
    }
}
