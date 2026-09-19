<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'includes',
        'price',
        'numeric_price',
        'image_url',
        'image_position',
        'order',
    ];

    /**
     * Devuelve el contenido de "includes" como arreglo de líneas,
     * para poder pintarlo como lista de bullets en la vista pública.
     */
    public function getIncludesListAttribute(): array
    {
        if (empty($this->includes)) {
            return [];
        }

        return collect(explode("\n", $this->includes))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
