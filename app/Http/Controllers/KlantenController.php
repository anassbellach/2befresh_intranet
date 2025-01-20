<?php

namespace App\Http\Controllers;

use App\Jobs\GeocodeKlant;
use App\Models\Klant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class KlantenController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Klant::class);

        $query = Klant::withTrashed();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('klant_id', 'like', "%$search%")
                    ->orWhere('klant_bedrijfsnaam', 'like', "%{$search}%")
                    ->orWhere('klant_plaats', 'like', "%{$search}%")
                    ->orWhere('klant_mail', 'like', "%{$search}%")
                    ->orWhere('klant_sinds', 'like', "%{$search}%")
                    ->orWhereRaw("IF(deleted_at === null, 'actief', 'inactief') LIKE ?", ["%{$search}%"]);
            });
        }

        // Sorting functionality
        $sortKey = $request->get('sortKey', 'klant_id'); // Default sort key
        $sortOrder = $request->get('sortOrder', 'asc');    // Default sort order
        $query->orderBy($sortKey, $sortOrder);

        // Paginate the results
        $klanten = $query->paginate(10);

        // Return the paginated data to the view
        return inertia('Klanten/Index', [
            'klanten' => $klanten,
            'filters' => [
                'search' => $request->get('search', ''),
                'sortKey' => $sortKey,
                'sortOrder' => $sortOrder,
            ],
        ]);
    }


    public function create()
    {
        return inertia('Klanten/Create');
    }

    public function store(Request $request)
    {
        // Set the current date for klant_sinds in DD-MM-YYYY format
        $currentDate = now()->format('d-m-Y');
        $request->merge(['klant_sinds' => $currentDate]);

        // Validate and create the klant
        $klant = Klant::create(
            $request->validate([
                'klant_bedrijfsnaam' => 'required|string|max:255',
                'klant_kvk' => 'required|digits:8',
                'klant_mail' => 'required|email|max:50',
                'klant_telefoon' => 'required|string|max:15',
                'klant_sinds' => 'required|string|max:10',
                'klant_adres' => 'required|string|max:255',
                'klant_postcode' => 'required|string|max:10',
                'klant_plaats' => 'required|string|max:255',
                'klant_land' => 'required|string|max:255',
                'klant_actief' => 'required|boolean',
            ])
        );

        // Geocode the address
        $fullAddress = "{$klant->klant_adres}, {$klant->klant_postcode}, {$klant->klant_plaats}, {$klant->klant_land}";
        $coordinates = $this->geocodeAddress($fullAddress);

        if ($coordinates) {
            $klant->latitude = $coordinates['lat'];
            $klant->longitude = $coordinates['lng'];
            $klant->save();
        }

        // Redirect with success message
        return redirect()->route('klant.index')
            ->with('success', 'Klant succesvol aangemaakt!');
    }

    public function show(Klant $klant)
    {
        return inertia('Klanten/Show', [
            'klant' => $klant
        ]);
    }

    public function edit(Klant $klant)
    {
        return inertia('Klanten/Edit', [
            'klant' => $klant
        ]);
    }

    public function update(Request $request, Klant $klant)
    {
        // Validate and update the klant
        $validatedData = $request->validate([
            'klant_bedrijfsnaam' => 'required|string|max:255',
            'klant_kvk' => 'required|digits:8',
            'klant_mail' => 'required|email|max:50',
            'klant_telefoon' => 'required|string|max:15',
            'klant_adres' => 'required|string|max:255',
            'klant_postcode' => 'required|string|max:10',
            'klant_plaats' => 'required|string|max:255',
            'klant_land' => 'required|string|max:255',
        ]);

        $klant->update($validatedData);

        // Geocode the updated address
        $fullAddress = "{$klant->klant_adres}, {$klant->klant_postcode}, {$klant->klant_plaats}, {$klant->klant_land}";
        $coordinates = $this->geocodeAddress($fullAddress);

        if ($coordinates) {
            $klant->latitude = $coordinates['lat'];
            $klant->longitude = $coordinates['lng'];
            $klant->save();
        }

        return redirect()->route('klant.index')
            ->with('success', 'Klantgegevens succesvol bijgewerkt!');
    }


    public function destroy(Klant $klant)
    {
        $klant->deleteOrFail();

        return redirect()->route('klant.index')
            ->with('success', 'Klant succesvol verwijderd!');
    }

    public function restore(Klant $klant)
    {
        $klant->restore();

        return redirect()->route('klant.index')
            ->with('success', 'Klant succesvol hersteld!');
    }

    public function statistieken()
    {
        return inertia('Klanten/Statistieken/Index', [
            'klanten_per_plaats' => Klant::selectRaw('klant_plaats, COUNT(*) as count')
                ->groupBy('klant_plaats')
                ->pluck('count', 'klant_plaats'),
        ]);
    }

    public function updateCoordinates()
    {
        Klant::chunk(50, function ($klanten) {
            foreach ($klanten as $klant) {
                GeocodeKlant::dispatch($klant);
            }
        });

        return redirect()->route('klant.index')
            ->with('success', 'Geocoding-taken succesvol gestart!');
    }

    public function updateCreatedAtWithChunking()
    {
        Klant::chunk(100, function ($records) {
            foreach ($records as $record) {
                $date = Carbon::createFromDate($record->klant_sinds, 1, 1);
                $record->created_at = $date;
                $record->save();
            }
        });

        return redirect()->route('klant.index')
            ->with('success', 'Created_at-velden succesvol bijgewerkt!');
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

        return null; // Return null if no results were found
    }
}
