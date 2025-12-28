<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'google_map_embed_url',
    ];
}
