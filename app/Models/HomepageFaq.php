<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageFaq extends Model
{
    protected $fillable = [
        'title',
        'heading',
        'question',
        'answer',
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
