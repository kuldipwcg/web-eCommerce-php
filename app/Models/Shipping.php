<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Shipping extends Model
{
    use HasFactory;
    protected $table='shippings';
    protected $primaryKey = 'id';
   
    
  protected $fillable=['order_id','first_name','last_name','email','address','zip_code','mobile_numer','country','state','city','shipping_cost'];

  protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
