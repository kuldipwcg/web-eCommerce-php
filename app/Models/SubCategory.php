<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public $table = 'sub_categories';
    protected $primaryKey = 'id';
   
    protected $guarded = [];
<<<<<<< HEAD
<<<<<<< HEAD
    protected $fillable = ['category_id','product_id','category_type'];
=======
=======
>>>>>>> 7363e18 (category,sub-category and cart api)
    protected $fillable = ['category_id','category_name'];
    protected $dates=['deleted_at'];
>>>>>>> 7363e18 (category,sub-category and cart api)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
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

