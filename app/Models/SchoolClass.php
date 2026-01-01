<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'level',
        'academic_year',
        'age_range',
        'term',
        'class_teacher_id',
        'capacity',
        'current_enrollment',
        'status',
        'description',
        'price',
        'website_visible',
        'website_description',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'website_visible' => 'boolean',
        ];
    }

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_student')
            ->withPivot('academic_year', 'enrollment_date', 'status')
            ->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_subject')
            ->withPivot('teacher_id', 'academic_year', 'weekly_periods', 'status')
            ->withTimestamps();
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class, 'class_id');
    }
}

