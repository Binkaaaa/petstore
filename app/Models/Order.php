<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{    
    protected $guarded = [];
    
    protected $fillable = [
        'user_id',
        'total_price',
        'order_status',     // e.g., pending, completed
        'order_type',       // 'pickup' or 'delivery'
        'delivery_address',
        'delivery_city',
        'delivery_postcode',
        'delivery_phone',   // contact number for delivery
        'delivery_status',  // e.g., not dispatched, dispatched, delivered
        'created_at',
    ];

    public function orderItems()
    {
        return $this->hasMany(Order_Item::class);
    }

    
    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
