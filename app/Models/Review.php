<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";
    protected $primaryKey = 'id';

    protected $fillable = [
        "product_id",
        "user_id",
        "rating",
        "review",
    ];
    protected $hidden = ['created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
