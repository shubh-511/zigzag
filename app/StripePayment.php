<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripePayment extends Model
{
    //
    protected $fillable = [
        'txn_id', 'object', 'amount','amount_refunded', 'application', 
        'application_fee', 'application_fee_amount', 'balance_transaction', 
        'captured', 'created', 'currency', 'customer', 'description', 
        'destination', 'dispute', 'failure_code', 'failure_message', 
        'fraud_details', 'invoice', 'livemode', 'metadata', 'on_behalf_of', 
        '_order', 'outcome', 'paid', 'payment_intent', 'receipt_email', 
        'receipt_number', 'refunded', 'refunds', 'review', 'shipping', 
        'source', 'source_transfer', 'statement_descriptor', 'status', 'transfer_data', 'transfer_group',

    ];
}

//_order