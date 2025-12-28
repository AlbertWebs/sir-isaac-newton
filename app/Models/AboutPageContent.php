<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageContent extends Model
{
    protected $table = 'about_page_content';

    protected $fillable = [
        'section_type',
        'image',
        'title',
        'paragraph',
        'name',
        'description',
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
