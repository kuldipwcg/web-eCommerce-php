<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = ['product_colors'];
    protected $primaryKey = ['id'];
    protected $fillable = ['color'];

    public function product_image(){
        return $this->hasOne(ProductColor::class);
    }
}
