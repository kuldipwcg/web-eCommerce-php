<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Shipping extends Model
{
  
    protected $table='shippings';
   
    
    protected $fillable=['order_id','firstName','lastName','email','mobileNumber','address1','address2','zipCode','country','state','city','shippingCost'];
}
