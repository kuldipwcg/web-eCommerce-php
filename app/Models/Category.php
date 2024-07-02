<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
<<<<<<< HEAD

=======
=======
>>>>>>> 7363e18 (category,sub-category and cart api)
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
>>>>>>> 7363e18 (category,sub-category and cart api)

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories' ;
    protected $primaryKey = 'id';
   
    
    protected $guarded = [];

    protected $fillable = ['category_name','image','status','created_at','updated_at','deleted_at'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }

}
