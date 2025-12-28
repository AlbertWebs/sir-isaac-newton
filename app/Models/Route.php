<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    protected $fillable = [
        'name',
        'code',
        'vehicle_id',
        'driver_id',
        'type',
        'morning_pickup_time',
        'morning_dropoff_time',
        'afternoon_pickup_time',
        'afternoon_dropoff_time',
        'estimated_distance_km',
        'estimated_duration_minutes',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'morning_pickup_time' => 'datetime:H:i',
            'morning_dropoff_time' => 'datetime:H:i',
            'afternoon_pickup_time' => 'datetime:H:i',
            'afternoon_dropoff_time' => 'datetime:H:i',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function stops(): HasMany
    {
        return $this->hasMany(RouteStop::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'route_assignments')
            ->withPivot('pickup_stop_id', 'dropoff_stop_id', 'service_type', 'start_date', 'end_date', 'status')
            ->withTimestamps();
    }

    public function tripSessions(): HasMany
    {
        return $this->hasMany(TripSession::class);
    }
}

