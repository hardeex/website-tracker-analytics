<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'element_id',
        'page_url',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'user_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}