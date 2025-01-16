<?php

namespace App\Jobs;

use App\Models\Leverancier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeocodeLeverancier implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $leverancier;

    /**
     * Create a new job instance.
     */
    public function __construct(Leverancier $leverancier)
    {
        $this->leverancier = $leverancier;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $fullAddress = "{$this->leverancier->leverancier_adres}, {$this->leverancier->leverancier_postcode}, {$this->leverancier->leverancier_plaats}, {$this->leverancier->leverancier_land}";

        $coordinates = $this->geocodeAddress($fullAddress);

        if ($coordinates) {
            $this->leverancier->latitude = $coordinates['lat'];
            $this->leverancier->longitude = $coordinates['lng'];
            $this->leverancier->save();
        }
    }


    /**
     * Geocode an address using Google Maps Geocoding API.
     */
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
