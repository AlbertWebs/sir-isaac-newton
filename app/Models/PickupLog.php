<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickupLog extends Model
{
    protected $fillable = [
        'trip_session_id',
        'student_id',
        'route_stop_id',
        'action_type',
        'status',
        'scheduled_time',
        'actual_time',
        'latitude',
        'longitude',
        'notification_sent',
        'notification_sent_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_time' => 'datetime',
            'actual_time' => 'datetime',
            'notification_sent_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'notification_sent' => 'boolean',
        ];
    }

    public function tripSession(): BelongsTo
    {
        return $this->belongsTo(TripSession::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function routeStop(): BelongsTo
    {
        return $this->belongsTo(RouteStop::class);
    }
}

