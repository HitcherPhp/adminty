<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_category_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');
            $table->text('promotion_ids')->nullable();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->foreign('service_type_id')
                ->references('id')
                ->on('service_type');
            $table->boolean('is_vip');
            $table->decimal('price',65,2)->nullable();
            $table->string('html_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->boolean('published')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_category_product');
    }
}
