<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
       protected $fillable = ['client_name', 'client_email', 'products', 'total'];
    protected $casts = [
        'products' => 'array',
    ];
}
