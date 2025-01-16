<?php

namespace App\Console\Commands;

use App\Jobs\GeocodeLeverancier;
use App\Models\Leverancier;
use Illuminate\Console\Command;

class GeocodeLeveranciers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode:leveranciers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode all existing Leveranciers and update their latitude and longitude';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get all leveranciers (you can adjust the query based on your needs)
        $leveranciers = Leverancier::all();

        // Loop through each leverancier and dispatch the GeocodeLeverancier job
        foreach ($leveranciers as $leverancier) {
            GeocodeLeverancier::dispatch($leverancier);
        }

        $this->info('Geocoding process for all leveranciers has been started!');
    }
}
