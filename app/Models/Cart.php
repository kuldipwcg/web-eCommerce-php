<?php

namespace App\Models;

use Faker\Core\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;





class Cart extends Model
{
    use HasFactory;
 
    protected $table = 'carts' ;
   
    protected $fillable = ['user_id','product_id','quantity','total','order_placed','created_at','updated_at','deleted_at'];

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

   
}
