<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTimeline extends Model
{
    protected $table = 'history_timeline';

    protected $fillable = [
        'year',
        'title',
        'feature_label',
        'description',
        'order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'order' => 'integer',
            'year' => 'integer',
        ];
    }
}
