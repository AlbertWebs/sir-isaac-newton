<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;

class EnrollmentSubmission extends Model
{
    protected $fillable = [
        'child_name',
        'child_dob',
        'parent_name',
        'parent_email',
        'phone',
        'class_id',
        'additional_info',
        'notify_progress',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'child_dob' => 'date',
            'notify_progress' => 'boolean',
        ];
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
