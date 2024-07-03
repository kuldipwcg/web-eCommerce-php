<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;

class ProductVariants extends Model
{
    use HasFactory;

    protected $table = "productvariation";
    protected $primaryKey = "id";

    protected $fillable = ['product_id', 'color_id', 'size_id', 'quantity'];

    public function product(){
        $this->belongsTo(Product::class);
    }

    public function color(){
        $this->belongsTo(ProductColor::class);
    }

    public function size(){
        $this->belongsTo(ProductSize::class);
    }
}