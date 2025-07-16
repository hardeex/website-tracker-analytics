<?php
namespace App\Jobs;
use App\Models\Analytic;
use GeoIp2\Database\Reader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        Log::info('Processing event', ['data' => $this->data]);

        if ($this->data['event_type'] === 'site_registered') {
            Log::info('Skipping site_registered event', [
                'site_id' => $this->data['site_id'],
                'page_url' => $this->data['page_url'],
            ]);
            return;
        }

        try {
            $geoipPath = config('app.geoip_database_path');
            Log::info('GeoIP path', ['path' => $geoipPath]);
            if (!$geoipPath || !file_exists($geoipPath)) {
                Log::warning('GeoIP database not found', ['path' => $geoipPath]);
                $country = null;
                $city = null;
            } else {
                $reader = new Reader($geoipPath);
                $record = $reader->city($this->data['ip_address']);
                $country = $record->country->name ?? null;
                $city = $record->city->name ?? null;
            }
        } catch (\Exception $e) {
            Log::warning('GeoIP lookup failed', [
                'error' => $e->getMessage(),
                'ip_address' => $this->data['ip_address'],
            ]);
            $country = null;
            $city = null;
        }

        try {
            $analytic = Analytic::create([
                'site_id' => $this->data['site_id'],
                'event_type' => $this->data['event_type'],
                'page_url' => $this->data['page_url'],
                'element_id' => $this->data['element_id'] ?? null,
                'ip_address' => $this->data['ip_address'],
                'user_agent' => $this->data['user_agent'],
                'country' => $country,
                'city' => $city,
                'session_duration' => $this->data['session_duration'] ?? null,
                'session_id' => $this->data['session_id'] ?? null, // Added
            ]);
            Log::info('Analytic record created', ['id' => $analytic->id]);
        } catch (\Exception $e) {
            Log::error('Failed to save analytic record', [
                'error' => $e->getMessage(),
                'data' => $this->data,
            ]);
        }
    }
}