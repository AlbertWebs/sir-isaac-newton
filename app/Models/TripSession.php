<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripSession extends Model
{
    protected $fillable = [
        'route_id',
        'driver_id',
        'vehicle_id',
        'trip_type',
        'trip_date',
        'scheduled_start_time',
        'actual_start_time',
        'actual_end_time',
        'status',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'trip_date' => 'date',
            'scheduled_start_time' => 'datetime:H:i',
            'actual_start_time' => 'datetime:H:i',
            'actual_end_time' => 'datetime:H:i',
            'start_latitude' => 'decimal:8',
            'start_longitude' => 'decimal:8',
            'end_latitude' => 'decimal:8',
            'end_longitude' => 'decimal:8',
        ];
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function pickupLogs(): HasMany
    {
        return $this->hasMany(PickupLog::class);
    }
}

