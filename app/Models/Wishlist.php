<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Review;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = "wishlists";

    protected $fillable = [
        "user_id",
        "product_id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    } 

    public function review()
    {
        return $this->belongsTo(Review::class,"product_id","id");
    } 
}
