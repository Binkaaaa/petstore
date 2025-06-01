<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory;

        
    protected $guarded = [];
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'user_id'
    ];


    // The admin who added this product
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Users who bought this product
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user');
    }
        public function orderItems()
    {
        return $this->hasMany(Order_Item::class);
    }

    
        public function carts()
    {
        return $this->belongsToMany(Cart::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

        public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reviews()
    {
        // 'Review' is your MongoDB-backed model,
        // 'product_id' is the field in MongoDB
        // 'id' (or ' _id' if you’re using custom keys) is the local primary key
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}
    



