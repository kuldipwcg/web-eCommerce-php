<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = ['productColorSize_id', 'product_name', 'description', 'product_price', 'discounted_price', 'information', 'category_id'];

    public function product_image(){
       return $this->hasMany(ProductImage::class);
    }

    public function discounts(){
        return $this->belongsTo(Discount::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function product_colors(){
        return $this->belongsToMany(ProductColor::class, 'pivot_color','product_id','color_id');
    }

    public function product_sizes(){
        return $this->belongsToMany(ProductSize::class, 'pivot_size','product_id','size_id');
    }

    // public function product_color_sizes(){
    //     return $this->hasMany(ProductColorSize::class);
    // }


}
