<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Laravel\Passport\Passport;
use App\Http\Controllers\AdminController;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Admin extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $fillable = ['id', 'email', 'password'];
}
