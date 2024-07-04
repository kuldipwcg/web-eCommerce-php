<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public $table = 'sub_categories';
 
    protected $fillable = ['categoryId','subcategoryName'];
    public function category()
    {
        return $this->belongsTo(Category::class,'categoryId','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
