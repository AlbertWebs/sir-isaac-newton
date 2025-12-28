<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageFeature extends Model
{
    protected $fillable = [
        'section_title',
        'section_heading',
        'content',
        'image',
        'icon',
        'title',
        'paragraph',
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
