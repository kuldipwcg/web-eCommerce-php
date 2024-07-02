<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Billing extends Model
{
    use HasFactory;
    protected $table='billings';
    protected $primaryKey = 'id';
   
    
    protected $fillable=['order_id','first_name','last_name','email','address','zip_code','mobile_numer','country','state','city','shipping_cost'];


}
