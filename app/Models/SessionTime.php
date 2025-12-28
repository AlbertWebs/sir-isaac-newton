<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionTime extends Model
{
    protected $fillable = [
        'background_image',
        'title',
        'icon',
        'paragraph',
        'label',
        'time_range',
        'order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'order' => 'integer',
        ];
    }
}
