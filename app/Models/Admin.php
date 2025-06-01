<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

// class Admin extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;
//     protected $fillable = ['name', 'email', 'password'];

//     protected $hidden = ['password', 'remember_token'];
// }

class Admin extends User
{
     use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope('admin', function ($query) {
            $query->where('user_type', 'admin');
        });
    }
}
