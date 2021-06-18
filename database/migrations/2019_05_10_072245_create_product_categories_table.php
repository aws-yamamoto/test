<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('level');
            $table->integer('parent_product_category_id')->nullable();
            $table->string('name');
            $table->string('subname')->nullable();
            $table->date('valid_period_from');
            $table->date('valid_period_to');
            $table->integer('app_display_type')->nullable();
            $table->string('edit_status')->nullable();
            $table->integer('disp_type')->nullable();
            $table->integer('priority_order');
            $table->boolean('delete_type')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
