<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'kana',
        'address',
        'postcode',
        'tel',
        'user_id',
        'customer_id',
        'order',
        'sumprice',
        'delivery',
        'datetime',
        'time',
        'status',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items() 
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
