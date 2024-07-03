<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Ramsey\Uuid\Uuid;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    // protected $primaryKey = "id";
    // protected $keyType = 'string';
    // public $incrementing = false;


    protected $fillable = [
        'product_name',
        'description',
        'product_price',
        'discounted_price',
        'information',
        'category_id',
        'discount_id',
        'is_featured',
    ];

    public function product_image(){
       return $this->hasMany(Product::class);
    }

    public function discounts(){
        return $this->belongsTo(Discount::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function product_color_sizes(){
        return $this->hasMany(ProductColorSize::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class,'product_id','id');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function (Model $model) {
    //         $model->setAttribute($model->getKeyName(), Uuid::uuid4());
    //     });
    // }
}
