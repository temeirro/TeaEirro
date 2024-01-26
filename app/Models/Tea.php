<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tea extends Model
{
    protected $table = 'tea';
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'ingredients',
        'type_id',
        'origin_id',
    ];

    public function tea_type()
    {
        return $this->belongsTo(TeaType::class, 'type_id');
    }

    public function tea_origin()
    {
        return $this->belongsTo(TeaOrigin::class, 'origin_id');
    }

    public function tea_images()
    {
        return $this->hasMany(TeaImage::class);
    }

    public $timestamps = false;

}
