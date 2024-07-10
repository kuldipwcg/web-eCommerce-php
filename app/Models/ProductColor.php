<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;



class ProductColor extends Model
{
    use HasFactory,Notifiable;
    protected $primaryKey = "id";

    protected $fillable = ['color'];
    protected $hidden = ['created_at','updated_at'];

    public function product_variants()
    {
        return $this->hasMany(ProductVariants::class,'color_id','id');
    }

}
