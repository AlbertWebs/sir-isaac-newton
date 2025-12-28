<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RouteStop extends Model
{
    protected $fillable = [
        'route_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'stop_order',
        'estimated_arrival_time',
        'stop_type',
        'landmarks',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'estimated_arrival_time' => 'datetime:H:i',
        ];
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function pickupLogs(): HasMany
    {
        return $this->hasMany(PickupLog::class, 'route_stop_id');
    }
}

