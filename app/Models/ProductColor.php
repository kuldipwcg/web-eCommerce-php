<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductColor extends Model
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id';

    protected $fillable = ['color'];

    public function product_variants()
    {
        return $this->hasMany(ProductVariants::class);
    }
}
