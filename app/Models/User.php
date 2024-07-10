<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{

use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'email',
        'firstName',
        'lastName',
        'password',
        'phoneNo',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
        'address',
        'role',
        'created_at',
        'updated_at',
        'email_verified_at',
        'remember_token',
    ];
    
    /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */

    // method from CanResetPassword is overrided  
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
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
}

