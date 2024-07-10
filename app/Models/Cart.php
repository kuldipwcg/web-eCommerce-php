<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts' ;

    protected $fillable = ['user_id','product_id','quantity','total','order_placed','variants_id'];

    protected $hidden = ['created_at','updated_at'];
    protected $primaryKey = 'id';
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
