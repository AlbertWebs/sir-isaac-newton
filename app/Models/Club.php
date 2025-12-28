<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'teacher_id',
        'max_members',
        'status',
    ];

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'club_memberships')
            ->withPivot('academic_year', 'join_date', 'role', 'status')
            ->withTimestamps();
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClubSchedule::class);
    }
}

