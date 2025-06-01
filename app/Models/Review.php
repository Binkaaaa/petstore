<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;    // <-- official package namespace

class Review extends Model
{


protected $connection = 'mongodb';
protected $collection = 'reviews';

protected $fillable = ['product_id', 'user_id', 'rating', 'comment'];

// Optional: relations if you want to link users and products
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
