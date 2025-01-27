<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="footers";

    protected $fillable = ['address', 'email', 'contact','description','twitter','facebook','linkedIn','instagram'];
    protected $hidden = ['created_at','updated_at'];

}
