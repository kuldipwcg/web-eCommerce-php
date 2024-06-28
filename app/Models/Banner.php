<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


class Banner extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "banners";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        "banner_image",
        "banner_title",
        "banner_desc",
        "banner_link",
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
