<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasProfilePhoto;
     use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Relationship: user bought many products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user');
    }

    // User has one active cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }


    // User has many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function scopeOnlyUsers($query)
{
    return $query->where('user_type', 'user');
}
    

}
