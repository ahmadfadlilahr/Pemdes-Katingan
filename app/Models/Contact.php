<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'whatsapp',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'address',
        'google_maps_embed',
        'office_hours_open',
        'office_hours_close',
        'office_days',
    ];
}
