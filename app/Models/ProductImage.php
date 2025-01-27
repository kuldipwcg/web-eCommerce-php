<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = "product_images";
    protected $primaryKey = "id";

    protected $fillable = [
        "product_id",
        "product_image",
    ];
    protected $hidden = ['created_at','updated_at'];
    public function products(){
        return $this->hasMany(ProductImage::class);
     }

}
    