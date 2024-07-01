<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $fillable=['user_id','cart_id','order_date','order_status','total','image'];
   
    public function billings()
    {
        return $this->hasOne(Billing::class,'order_id','id');
    }

    public function shippings()
    {
        return $this->hasOne(Shipping::class,'order_id','id');
    }

    public function Payment()
    {
        return $this->hasOne(Payment::class,'order_id','id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
    
}
