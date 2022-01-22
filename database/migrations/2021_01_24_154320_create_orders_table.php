<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('number');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->on('customers')
                ->references('id');
            $table->unsignedBigInteger('reception_id');
            $table->foreign('reception_id')
                ->on('receptions')
                ->references('id');
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->foreign('promo_code_id')
                ->references('id')
                ->on('promo_codes');
            $table->decimal('base_price', 65,2);
            $table->decimal('basket_price', 65,2);
            $table->decimal('bonus_price', 65,2)->default(0.00);
            $table->decimal('total_weight',65,2)->default(0.00);
            $table->decimal('discount_sum',65,2)->default(0.00);
            $table->decimal('delivery_price',65,2)->default(0.00);
            $table->decimal('estimate_price',65,2)->default(0.00);
            $table->unsignedBigInteger('address_take_id')->nullable();
            $table->foreign('address_take_id')
                ->references('id')
                ->on('addresses');
            $table->unsignedBigInteger('address_return_id')->nullable();
            $table->foreign('address_return_id')
                ->references('id')
                ->on('addresses');
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');
            $table->text('customer_comment')->nullable();
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
