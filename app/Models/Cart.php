<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = ['user_id', 'product_id', 'quantity','status', 'order_placed'];

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
