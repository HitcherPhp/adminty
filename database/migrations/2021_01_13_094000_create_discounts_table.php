<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->decimal('percent', 5, 2)->default(0);
            $table->decimal('price',65,2)->default(0);
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('promotion_id');
            $table->text('product_ids')->nullable();
            $table->string('name');
            $table->text('description');
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}

