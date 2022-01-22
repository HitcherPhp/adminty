<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDayTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_day_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('weekday');
            $table->timeTz('work_from',0)->nullable();
            $table->timeTz('work_to',0)->nullable();
            $table->timeTz('break_from',0)->nullable();
            $table->timeTz('break_to',0)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_day_time');
    }
}
