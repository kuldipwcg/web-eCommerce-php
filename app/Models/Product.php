<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;
    protected $with = ['product_image'];
    // protected $with = ['reviews'];
    protected $table = "products";

    protected $primaryKey = "id";
    protected $fillable = [
        'product_name',
        'short_desc',
        'description',
        'information',
        'price',
        'category_id',
        'discount_type',
        'discount_value',
        'is_featured',
    ];

    public function product_image()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function product_variants(){
        return $this->hasMany(ProductVariants::class);
    }
}

