<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Category extends Model
{
    use HasFactory;
<<<<<<< Updated upstream
    
    protected $table = 'categories' ;
    protected $primaryKey = 'id';

    protected $fillable = ['category_name','image','status','created_at','updated_at','deleted_at'];
=======
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $fillable = ['category_name', 'sub_categories_id', 'image', 'status', 'created_at', 'updated_at', 'deleted_at'];
>>>>>>> Stashed changes

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class,'categoryId','id');
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
