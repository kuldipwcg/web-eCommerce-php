<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Shipping extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='shippings';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
  protected $fillable=['order_id','first_name','last_name','email','address','zip_code','mobile_numer','country','state','city','shipping_cost'];

  protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
