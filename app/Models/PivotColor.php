<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotColor extends Model
{
    use HasFactory;

    protected $table = "pivot_color";
    protected $guarded = [];
   
    

    protected $fillable = ['product_id','color_id'];



}
