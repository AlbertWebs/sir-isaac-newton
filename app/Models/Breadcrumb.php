<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    protected $fillable = [
        'page_key',
        'background_image',
        'title',
        'paragraph',
    ];

    protected function casts(): array
    {
        return [
            'background_image' => 'string',
        ];
    }
}
