<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Ramsey\Uuid\Uuid;
// use Illuminate\Database\Eloquent\SoftDeletes;
class SubCategory extends Model
{
    use HasFactory;
    // use SoftDeletes;
    public $table = 'sub_categories';
    // protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;
    // protected $guarded = [];
    protected $fillable = ['category_id','category_name'];
    // protected $dates=['deleted_at'];
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function (Model $model) {
    //         $model->setAttribute($model->getKeyName(), Uuid::uuid4());
           
    //     });
    // }
   
}

