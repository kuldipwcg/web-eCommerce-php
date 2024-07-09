<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['percentage','status'];
    protected $hidden = ['created_at','updated_at'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product');
    }
}
