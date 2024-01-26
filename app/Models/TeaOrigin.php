<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeaOrigin extends Model
{
    protected $table = 'tea_origins';
    use HasFactory;

    protected $fillable = [
        "name",
    ];
    public $timestamps = false;


}
