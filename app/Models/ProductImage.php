<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
class ProductImage extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "product_images";
    protected $guarded = [];
    // protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $primaryKey = "id";

    protected $fillable = [
        "product_id",
        "product_image",
    ];

    public function products(){
        return $this->hasMany(ProductImage::class);
     }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
