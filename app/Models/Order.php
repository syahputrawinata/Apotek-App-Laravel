<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_customer',
        'total_price',
    ];

    protected $casts = [
        'medicines' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // // Relasi Many to Many dengan Medicine
        // public function medicines()
        // {
        //     return $this->belongsToMany(Medicine::class, 'order_medicine', 'order_id', 'medicine_id')
        //                 ->withPivot('price', 'sub_price', 'qty'); // Kolom pivot sesuai dengan yang ada di tabel order_medicine
        // }
    
}
