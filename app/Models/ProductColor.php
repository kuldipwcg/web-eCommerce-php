<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ProductColor extends Model
{
    use HasFactory;

    protected $table = "product_colors";
    protected $primaryKey = "id";

    protected $fillable = ['color'];


    public function products(){
        return $this->belongsToMany(Product::class, 'pivot_color','product_id','color_id','id','id');
    }


}
