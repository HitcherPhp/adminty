<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->string('address', 100);
            $table->string('flat/office', 100)->nullable();
            $table->string('name',100)->nullable();
            $table->text('comment')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('courier')->nullable();
            $table->DateTime('date_time_from')->nullable();
            $table->DateTime('date_time_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
