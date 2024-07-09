<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['user_id', 'cart_id', 'order_date', 'status', 'total'];
    public function billings()
    {
        return $this->hasOne(Billing::class, 'order_id', 'id');
    }

    public function shippings()
    {
        return $this->hasOne(Shipping::class, 'order_id', 'id');
    }

    public function Payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
}
