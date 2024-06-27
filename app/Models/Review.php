<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    protected $primaryKey = "id";

    protected $fillable = [
        "product_id",
        "user_id",
        "rating",
        "review",
    ] ;
}
