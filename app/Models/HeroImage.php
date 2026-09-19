<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'caption',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
