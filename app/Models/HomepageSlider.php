<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSlider extends Model
{
    protected $fillable = [
        'image',
        'text',
        'button_text',
        'button_link',
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
