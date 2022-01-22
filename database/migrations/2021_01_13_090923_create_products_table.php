<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name', 100);
            $table->longText('meta_keywords')->nullable();
            $table->longText('product_tags')->nullable();
            $table->decimal('length', 65,1)->nullable();
            $table->decimal('width', 65,1)->nullable();
            $table->decimal('height', 65,1)->nullable();
            $table->decimal('weight', 65,3)->nullable();
            $table->string('period')->default('3-4 дня');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('images');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
