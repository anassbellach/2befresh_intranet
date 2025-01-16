<?php

namespace App\Jobs;

use App\Models\Klant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeocodeKlant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $klant;

    /**
     * Create a new job instance.
     */
    public function __construct(Klant $klant)
    {
        $this->klant = $klant;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $fullAddress = "{$this->klant->klant_adres}, {$this->klant->klant_postcode}, {$this->klant->klant_plaats}, {$this->klant->klant_land}";

        $coordinates = $this->geocodeAddress($fullAddress);

        if ($coordinates) {
            $this->klant->latitude = $coordinates['lat'];
            $this->klant->longitude = $coordinates['lng'];
            $this->klant->save();
        }
    }

    private function geocodeAddress($address)
    {
        $apiKey = 'AIzaSyDGt53_sxryMkf5PmuUSoPZ5xzWswB_5Rk';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key={$apiKey}";

        $response = file_get_contents($url);
        $data = json_decode($response);

        if (isset($data->results[0])) {
            return [
                'lat' => $data->results[0]->geometry->location->lat,
                'lng' => $data->results[0]->geometry->location->lng,
            ];
        }

        return null;
    }
}
