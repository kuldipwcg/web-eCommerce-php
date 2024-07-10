<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class newsletter extends Model
{
    use HasFactory; 


    protected $table = "newsletters";

    protected $fillable = [
        'address',
        'description',
        'email',
        'phone',
    ]; 
    protected $hidden = ['created_at','updated_at'];

}
