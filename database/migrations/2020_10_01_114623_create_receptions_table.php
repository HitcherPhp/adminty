<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->string('phone', 50);
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->timestamps();
            $table->decimal('length', 65,1)->nullable();
            $table->decimal('width', 65,1)->nullable();
            $table->decimal('height', 65,1)->nullable();
            $table->decimal('weight', 65,3)->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')
                ->references('id')
                ->on('staff');
            $table->boolean('household')->default(false);
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
        Schema::dropIfExists('receptions');
    }
}
