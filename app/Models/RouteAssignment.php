<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteAssignment extends Model
{
    protected $fillable = [
        'route_id',
        'student_id',
        'pickup_stop_id',
        'dropoff_stop_id',
        'service_type',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function pickupStop(): BelongsTo
    {
        return $this->belongsTo(RouteStop::class, 'pickup_stop_id');
    }

    public function dropoffStop(): BelongsTo
    {
        return $this->belongsTo(RouteStop::class, 'dropoff_stop_id');
    }
}

