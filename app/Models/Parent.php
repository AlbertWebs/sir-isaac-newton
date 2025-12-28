<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Parent extends Authenticatable
{
    use HasApiTokens;
    
    protected $table = 'parents';

    protected $fillable = [
        'parent_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'password',
        'relationship',
        'occupation',
        'address',
        'photo',
        'status',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student')
            ->withPivot('relationship_type', 'is_primary', 'can_pickup', 'can_dropoff', 'emergency_contact')
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

