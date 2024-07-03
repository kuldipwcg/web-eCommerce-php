<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Banner extends Model
{
    use HasFactory;

    protected $table = "banners";
   
    


    protected $fillable = [
        "banner_image",
        "banner_title",
        "banner_desc",
        "banner_link",
    ];


}
