<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ProductSize extends Model
{
    use HasFactory,Notifiable;
    protected $guarded = [];
    protected $fillable = ['size'];

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function products(){
        return $this->belongsToMany(Product::class, 'pivot_size','product_id','size_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }


}
