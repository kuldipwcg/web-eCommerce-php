<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PivotSize extends Model
{
    use HasFactory;

    protected $table = "pivot_size";
    protected $primaryKey = "id";


    protected $fillable = ['product_id','size_id'];

}
