<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'year',
        'color',
        'capacity',
        'vehicle_type',
        'insurance_number',
        'insurance_expiry',
        'inspection_expiry',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'insurance_expiry' => 'date',
            'inspection_expiry' => 'date',
        ];
    }

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }

    public function tripSessions(): HasMany
    {
        return $this->hasMany(TripSession::class);
    }
}

