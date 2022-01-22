<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleFactoryReceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_factory_reception', function (Blueprint $table) {
            $table->bigIncrements('schedule_id');
            $table->unsignedBigInteger('factory_id')->nullable();
            $table->foreign('factory_id')
                ->on('factories')
                ->references('id');
            $table->unsignedBigInteger('reception_id')->nullable();
            $table->foreign('reception_id')
                ->on('receptions')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_factory_reception');
    }
}
