<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_item';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'color','size','unit_price'];

    protected $hidden = ['created_at','updated_at'];

    protected $primaryKey = 'id';
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
