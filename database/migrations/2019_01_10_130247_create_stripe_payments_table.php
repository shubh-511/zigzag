<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('txn_id');
            $table->string('object');
            $table->string('amount');
            $table->string('amount_refunded');
            $table->string('application');
            $table->string('application_fee');
            $table->string('application_fee_amount');
            $table->string('balance_transaction');
            $table->string('captured');
            $table->string('created');
            $table->string('currency');
            $table->string('customer');
            $table->string('description');
            $table->string('destination');
            $table->string('dispute');
            $table->string('failure_code');
            $table->string('failure_message');
            $table->string('fraud_details');
            $table->string('invoice');
            $table->string('livemode');
            $table->string('metadata');
            $table->string('on_behalf_of');
            $table->string('order');    
            $table->string('outcome'); //nested data Like outcome{ "network":"xxx","reason":"xxxx",}
            $table->string('paid');
            $table->string('payment_intent');
            $table->string('receipt_email');
            $table->string('receipt_number');
            $table->string('refunded');
            $table->string('refunds');//nested data Like outcome{ "object":"xxx","data":"xxxx",}
            $table->string('review');
            $table->string('shipping');
            $table->string('source'); //nested data Like outcome{ "id":"xxx","address_city":"xxxx",}
            $table->string('source_transfer');
            $table->string('statement_descriptor');
            $table->string('status');
            $table->string('transfer_data');
            $table->string('transfer_group');
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
        Schema::dropIfExists('stripe_payments');
    }
}
