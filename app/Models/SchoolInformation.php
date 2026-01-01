<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolInformation extends Model
{
    protected $table = 'school_information';

    protected $fillable = [
        'name',
        'motto',
        'vision',
        'mission',
        'about',
        'email',
        'phone',
        'phone_secondary',
        'address',
        'website',
        'logo',
        'enroll_image_1',
        'enroll_image_2',
        'facilities',
        'programs',
        'social_media',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
            'programs' => 'array',
            'social_media' => 'array',
        ];
    }
}

