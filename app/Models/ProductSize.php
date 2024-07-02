<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class ProductSize extends Model
{
    use HasFactory,Notifiable;
    protected $guarded = [];
    protected $fillable = ['size'];

    protected $primaryKey = 'id';
   
    

    public function products(){
        return $this->belongsToMany(Product::class, 'pivot_size','product_id','size_id');
    }



}
