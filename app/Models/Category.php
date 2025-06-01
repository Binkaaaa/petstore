<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'name',
    ];

    // Category has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    
}
