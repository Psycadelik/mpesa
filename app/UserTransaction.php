<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected $table = 'user_transactions';

    protected $fillable = ['user_id', 'amount', 'transaction_ref', 'transaction_time'];
}
