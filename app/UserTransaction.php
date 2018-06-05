<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected $table = 'user_transactions';

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'account_number', 'amount','business_short_code',
                            'invoice_no','account_balance','third_party_id','msisdn','transaction_id','transaction_time'];
}
