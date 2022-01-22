<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityFranchiseFactoryReceptionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_franchise_factory_reception_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->unsignedBigInteger('franchise_id')->nullable();
            $table->foreign('franchise_id')
                ->references('id')
                ->on('franchises');
            $table->unsignedBigInteger('factory_id')->nullable();
            $table->foreign('factory_id')
                ->references('id')
                ->on('factories');
            $table->unsignedBigInteger('reception_id')->nullable();
            $table->foreign('reception_id')
                ->references('id')
                ->on('receptions');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('staff');
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_franchise_factory_reception_user');
    }
}
