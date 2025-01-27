<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Billing extends Model
{
   
    protected $table='billings';
   
    
    protected $fillable=['order_id','firstName','lastName','email','mobileNumber','address1','address2','zipCode','country','state','city','shippingCost'];
    protected $hidden = ['created_at','updated_at'];


}
