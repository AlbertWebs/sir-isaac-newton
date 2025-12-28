<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'student_number',
        'admission_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'photo',
        'password',
        'date_of_birth',
        'gender',
        'level_of_education',
        'nationality',
        'id_passport_number',
        'next_of_kin_name',
        'next_of_kin_mobile',
        'address',
        'status',
        'uses_transport',
        'medical_info',
        'allergies',
        'emergency_medical_contact',
        'authorized_pickup_persons',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'uses_transport' => 'boolean',
            'authorized_pickup_persons' => 'array',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function courseRegistrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(StudentResult::class);
    }

    public function registeredCourses()
    {
        return $this->belongsToMany(Course::class, 'course_registrations')
            ->withPivot('academic_year', 'term', 'registration_date', 'status', 'notes')
            ->withTimestamps();
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Parent::class, 'parent_student')
            ->withPivot('relationship_type', 'is_primary', 'can_pickup', 'can_dropoff', 'emergency_contact')
            ->withTimestamps();
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_student')
            ->withPivot('academic_year', 'enrollment_date', 'status')
            ->withTimestamps();
    }

    public function routeAssignments(): HasMany
    {
        return $this->hasMany(RouteAssignment::class);
    }

    public function pickupLogs(): HasMany
    {
        return $this->hasMany(PickupLog::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_memberships')
            ->withPivot('academic_year', 'join_date', 'role', 'status')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        $name .= ' ' . $this->last_name;
        return $name;
    }
}
