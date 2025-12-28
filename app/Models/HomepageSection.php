<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'section_type',
        'title',
        'heading',
        'paragraph',
        'button_text',
        'button_link',
        'background_image',
        'icon',
        'images',
        'content',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'images' => 'array',
        ];
    }
}
