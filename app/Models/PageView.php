<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'page_url',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'user_id',
        'session_duration',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}