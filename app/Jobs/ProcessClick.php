<?php


namespace App\Jobs;

use App\Models\Click;
use GeoIp2\Database\Reader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ProcessClick implements ShouldQueue
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

        Click::create([
            'site_id' => $this->data['site_id'],
            'element_id' => $this->data['element_id'] ?? null,
            'page_url' => $this->data['page_url'],
            'ip_address' => $this->data['ip_address'],
            'user_agent' => $this->data['user_agent'],
            'country' => $country,
            'city' => $city,
            'user_id' => $this->data['user_id'] ?? null,
        ]);
    }
}