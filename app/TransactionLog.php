<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'content'];

    protected $date = ['deleted_at'];
}
