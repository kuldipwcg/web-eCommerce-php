<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PivotSize extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "pivot_size";
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['product_id','size_id'];


    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
