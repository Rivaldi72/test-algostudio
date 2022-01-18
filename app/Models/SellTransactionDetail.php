<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellTransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'sell_transaction_details';

    protected $fillable = [
        'product_id',
        'sell_id',
        'qunatity'
    ];
}
