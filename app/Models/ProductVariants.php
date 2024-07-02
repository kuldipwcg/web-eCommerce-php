<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
    use HasFactory;

    protected $table = "productvariation";
    protected $primaryKey = "id";

    protected $fillable = ['product_id', 'color_id', 'size_id', 'quantity'];

    public function products(){
        $this->belongsTo(Product::class);
    }

    public function colors(){
        $this->belongsTo(ProductColor::class);
    }

    public function sizes(){
        $this->belongsTo(ProductSize::class);
    }
}
