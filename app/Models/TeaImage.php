<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeaImage extends Model
{
    protected $table = 'tea_images';
    use HasFactory;

    protected $fillable = [
        'name',
        'tea_id',
    ];

    public function tea()
    {
        return $this->belongsTo(Tea::class);
    }

    public $timestamps = false;


}
