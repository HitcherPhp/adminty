<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bonus_type_id');
            $table->foreign('bonus_type_id')
                ->references('id')
                ->on('bonus_types');
            $table->decimal('points', 65, 2);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
            $table->enum('event', ['added', 'subtracted', 'burned']);
            $table->dateTime('start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonus_points');
    }
}
