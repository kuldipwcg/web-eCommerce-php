<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorSize extends Model
{
    use HasFactory;

    protected $table = ['product_color_sizes'];

    protected $primaryKey = ['id'];

    protected $fillable = ['product_color_id','product_size_id'];

    public function product_colors(){
        return $this->belongsTo(ProductColor::class);
    }  

    public function product_sizes(){
        return $this->belongsTo(ProductSize::class);
    }
}
