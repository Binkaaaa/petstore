<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;


class Cart extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];


    // Cart belongs to a user

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product')->withPivot('quantity');
    }

    public function items()
{
    return $this->hasMany(CartItem::class);
}

}
