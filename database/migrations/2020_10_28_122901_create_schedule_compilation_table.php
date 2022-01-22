<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleCompilationTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('schedule_compilation', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')
                ->on('schedule_factory_reception')
                ->references('schedule_id');
            $table->unsignedBigInteger('schedule_day_time_id');
            $table->foreign('schedule_day_time_id')
                ->on('schedule_day_time')
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
        Schema::dropIfExists('schedule_compilation');
    }
}
