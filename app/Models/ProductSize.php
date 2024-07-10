<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariants;


class ProductSize extends Model
{
    use HasFactory,Notifiable;
    protected $primaryKey = "id";

    protected $fillable = ['size'];
    protected $hidden = ['created_at','updated_at'];
    
    public function product_variants()
    {
        return $this->hasMany(ProductVariants::class);
    }

}