<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['customer_name', 'item_id'];

    public $timestamps = false;
}
