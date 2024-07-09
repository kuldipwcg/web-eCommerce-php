<?php

namespace App\Models;

use Faker\Core\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [ 'product_id', 'quantity', 'color', 'size','variants_id','order_placed'];
    protected $hidden = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    } 

    public function productvariation()
    {
        return $this->hasOne(ProductVariants::class);
    } 
}


