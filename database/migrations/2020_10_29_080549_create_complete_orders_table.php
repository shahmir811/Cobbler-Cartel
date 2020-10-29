<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompleteOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complete_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();

            $table->date('order_date');
            $table->time('order_time', 0);
            $table->date('order_dispatch_date');
            $table->timestamp('order_received_at', 0);
            $table->string('billing_customer');
            $table->string('billing_company_name')->nullable(); // nullable
            $table->string('billing_country');
            $table->string('billing_state');
            $table->string('billing_city');
            $table->text('billing_address');
            $table->string('billing_zip_code');
            $table->string('delivery_customer');
            $table->string('delivery_company_name')->nullable(); // nullable
            $table->string('delivery_country');
            $table->string('delivery_state');
            $table->string('delivery_city');
            $table->text('delivery_address');
            $table->string('delivery_zip_code');
            $table->string('buyer_phone');
            $table->text('shipping_label');
            $table->string('buyer_email');
            $table->string('delivery_method');
            $table->string('item_name');
            $table->string('item_variant');
            $table->string('sku')->nullable(); // nullable
            $table->integer('quantity');
            $table->double('item_price', 8, 2);
            $table->float('item_weight', 4, 2);
            $table->string('item_custom_text')->nullable(); // nullable
            $table->string('coupon')->nullable(); // nullable
            $table->text('notes_to_seller')->nullable(); // nullable
            $table->integer('shipping');
            $table->integer('tax');
            $table->integer('gift_card');
            $table->double('total', 8, 2);
            $table->string('currency');
            $table->string('payment_mentod');
            $table->string('payment');
            $table->string('fulfillment');
            $table->integer('refund');
            $table->double('total_after_refund', 8, 2); 
            $table->integer('quantity_refunded');
            $table->integer('quatity_restocked');
            $table->text('additional_info')->nullable(); // nullable


            $table->foreignId('user_id');
            $table->foreignId('statuses_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('statuses_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complete_orders');
    }
}
