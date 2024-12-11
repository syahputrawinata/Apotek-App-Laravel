<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'price',
        'stock',
    ];

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_medicine', 'medicine_id', 'order_id')
    //                 ->withPivot('price', 'sub_price', 'qty');
    // }
}

