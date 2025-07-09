<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    protected $table = 'analytics';

    protected $fillable = [
        'site_id',
        'event_type',
        'page_url',
        'element_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'session_duration',
    ];
}