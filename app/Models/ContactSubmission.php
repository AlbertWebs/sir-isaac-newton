<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'message',
        'is_read',
        'read_at',
    ];

    public function getNameAttribute($value)
    {
        // If first_name and last_name exist, prioritize them
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }

        // Otherwise, fall back to the original name column
        return $value;
    }

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }
}
