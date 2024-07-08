<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

use HasApiTokens, HasFactory, Notifiable;

    protected $table="users";
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'firstName',
        'lastName',
        // 'image',
        'password',
<<<<<<< Updated upstream
        'confirmPassword',
=======
        'confirm_password', 
>>>>>>> Stashed changes
        'dob',
        'phoneNo',
        'address',
        'role',
    ];

public function review(){
    return $this->hasMany(Review::class,'user_id','id');
}

public function wishlist()
{
    return $this->hasMany(Wishlist::class,'user_id','id');
}

public function order()
{
    return $this->hasMany(Order::class,'user_id','id');
}

    public function cart()
    {
        return $this->hasMany(Cart::class,'user_id','id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'dob',
        'phone_no',
        'address',
        'role',
        'remember_token',
    ];

/**
 * The attributes that should be cast.
 *
 * @var array<string, string>
 */
protected $casts = [
    'email_verified_at' => 'datetime',
];
}