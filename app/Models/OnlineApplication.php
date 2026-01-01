<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineApplication extends Model
{
    protected $fillable = [
        'child_name',
        'child_dob',
        'parent_name',
        'parent_email',
        'phone',
        'school_class_id',
        'additional_info',
        'notify_progress',
        'status',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}

