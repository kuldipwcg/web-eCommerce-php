<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table='shippings';
  protected $fillable=['order_id','first_name','last_name','email','address','zip_code','mobile_numer','country','state','city','shipping_cost'];

}
