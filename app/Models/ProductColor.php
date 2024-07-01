<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ProductColor extends Model
{
    use HasFactory;

    protected $table = ['product_colors'];
    protected $fillable = ['color'];

    protected $primaryKey = 'id';
   
    


    public function products(){
        return $this->belongsToMany(Product::class, 'pivot_color','product_id','color_id');
    }


}
