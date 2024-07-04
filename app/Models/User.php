<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
class User extends Authenticatable
{

use HasApiTokens, HasFactory, Notifiable;

    protected $table="users";

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
        'confirmPassword',
        'dob',
        'phoneNo',
        'address',
        'role',
    ];


    // public function resetpassword($password){
        
    //     $this->password;

    // }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // public function toMail($notifiable)
    // {
    //     if (static::$toMailCallback) {
    //         return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    //     }

    //     return $this->buildMailMessage($this->resetUrl($notifiable));
    // }

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
        'password',
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