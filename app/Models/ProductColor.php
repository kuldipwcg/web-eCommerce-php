<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


class ProductColor extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "product_colors";
    protected $guarded = [];
    protected $fillable = ['color'];

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;



    public function product_image()
    {
        return $this->hasOne(ProductColor::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
