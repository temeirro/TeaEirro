<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeaType extends Model
{
    protected $table = 'tea_types';
    use HasFactory;

    protected $fillable = [
        "name",
    ];


}
