<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'start_date', 
        'location', 
        'capacity', 
        'image_url',
        'recommendations'
    ];

    // --- AQUÍ ESTÁ LA CORRECCIÓN ---
    // Esta línea convierte el texto de la base de datos en un objeto manipulable
    protected $casts = [
        'start_date' => 'datetime',
    ];

    // Relación con participantes
    public function participants()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}