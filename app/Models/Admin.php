<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Admin extends Authenticatable
{
   
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $fillable = ['email', 'password','firstName','lastName','image','phoneNumber'];

    protected $hidden = [

        'created_at',
        'updated_at',

    ];
    
}
