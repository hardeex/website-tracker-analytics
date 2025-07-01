<?php

namespace App\Jobs;

use App\Models\PageView;
use GeoIp2\Database\Reader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ProcessPageView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            $reader = new Reader(config('app.geoip_database_path'));
            $record = $reader->city($this->data['ip_address']);
            $country = $record->country->name;
            $city = $record->city->name;
        } catch (\Exception $e) {
            $country = null;
            $city = null;
        }

        PageView::create([
            'site_id' => $this->data['site_id'],
            'page_url' => $this->data['page_url'],
            'ip_address' => $this->data['ip_address'],
            'user_agent' => $this->data['user_agent'],
            'country' => $country,
            'city' => $city,
            'user_id' => $this->data['user_id'] ?? null,
            'session_duration' => $this->data['session_duration'] ?? null,
        ]);
    }
}