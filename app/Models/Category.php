<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories' ;

    protected $fillable = ['category_name','image','status','created_at','updated_at','deleted_at'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class,'categoryId','id');
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }

}
