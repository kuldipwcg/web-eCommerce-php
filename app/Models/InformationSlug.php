<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationSlug extends Model
{
    use HasFactory;

    protected $table="information_slugs";

    protected $fillable=["slug","description"];
}
