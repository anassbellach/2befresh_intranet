<?php

namespace App\Http\Controllers;

use App\Jobs\GeocodeLeverancier;
use App\Models\Leverancier;
use Illuminate\Http\Request;

class LeveranciersController extends Controller
{
    public function index(Request $request)
    {
        $query = Leverancier::withTrashed();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('leverancier_id', 'like', "%$search%")
                    ->orWhere('leverancier_bedrijfsnaam', 'like', "%$search%")
                    ->orWhere('leverancier_plaats', 'like', "%$search%")
                    ->orWhere('leverancier_email', 'like', "%$search%")
                    ->orWhereRaw('IF(leverancier.deleted_at === null, "actief", "inactief") like ?', ["%$search%"]);
            });
        }

        // Sorting functionality
        $sortKey = $request->get('sortKey', 'leverancier_id'); // Default sort key
        $sortOrder = $request->get('sortOrder', 'asc');    // Default sort order
        $query->orderBy($sortKey, $sortOrder);

        // Paginate the results
        $leveranciers = $query->paginate(10);

        return inertia('Leveranciers/Index',
            [
               'leveranciers' => $leveranciers,
                'filters' => [
                    'search' => $request->get('search', ''),
                    'sortKey' => $sortKey,
                    'sortOrder' => $sortOrder,
                ],
            ]);
    }

    public function create()
    {
        return inertia('Leveranciers/Create');
    }

    public function store(Request $request)
    {

        $leverancier = Leverancier::create(
            $request->validate([
                'leverancier_bedrijfsnaam' => 'required|string|max:255',
                'leverancier_email' => 'nullable|email|max:255',
                'leverancier_telefoon' => 'nullable|string|max:15',
                'leverancier_sinds' => 'required|string|max:10',
                'leverancier_adres' => 'required|string|max:255',
                'leverancier_postcode' => 'required|string|max:10',
                'leverancier_plaats' => 'required|string|max:255',
                'leverancier_land' => 'required|string|max:255',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'leverancier_actief' => 'required|boolean',
            ])
        );

        // Geocode the address
        $fullAddress = "{$leverancier->leverancier_adres}, {$leverancier->leverancier_postcode}, {$leverancier->leverancier_plaats}, {$leverancier->leverancier_land}";
        $coordinates = $this->geocodeAddress($fullAddress);

        if ($coordinates) {
            $leverancier->latitude = $coordinates['lat'];
            $leverancier->longitude = $coordinates['lng'];
            $leverancier->save();
        }

        return redirect()->route('leverancier.index')
            ->with('success', 'Leverancier succesvol aangemaakt!');
    }

    public function show(Leverancier $leverancier)
    {
        return inertia('Leveranciers/Show', [
            'leverancier' => $leverancier
        ]);
    }

    public function edit(Leverancier $leverancier)
    {
        return inertia('Leveranciers/Edit', [
            'leverancier' => $leverancier
        ]);
    }

    public function update(Request $request, Leverancier $leverancier)
    {
        $leverancier->update(
            $request->validate([
                'leverancier_bedrijfsnaam' => 'required|string|max:255',
                'leverancier_email' => 'nullable|email|max:255',
                'leverancier_telefoon' => 'nullable|string|max:15',
                'leverancier_sinds' => 'nullable|date',
                'leverancier_adres' => 'required|string|max:255',
                'leverancier_postcode' => 'required|string|max:10',
                'leverancier_plaats' => 'required|string|max:255',
                'leverancier_land' => 'required|string|max:255',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'leverancier_actief' => 'required|boolean',
            ])
        );

        return redirect()->route('leverancier.index')
            ->with('success', 'Leverancier succesvol bijgewerkt!');
    }

    public function destroy(Leverancier $leverancier)
    {
        $leverancier->deleteOrFail();

        return redirect()->route('leverancier.index')
            ->with('success', 'Leverancier succesvol verwijderd!');
    }

    public function restore(Leverancier $leverancier)
    {
        $leverancier->restore();

        return redirect()->route('leverancier.index')
            ->with('success', 'Leverancier succesvol hersteld!');
    }

    public function statistieken()
    {
        return inertia('Leveranciers/Statistieken/Index',[
            'leveranciers_per_plaats' => Leverancier::selectRaw('leverancier_plaats, COUNT(*) as count')
                ->groupBy('leverancier_plaats')
                ->pluck('count', 'leverancier_plaats'),
        ]);
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

    public function updateCoordinates()
    {
        Leverancier::withTrashed()->chunk(50, function ($leveranciers) {
            foreach ($leveranciers as $leverancier) {
                GeocodeLeverancier::dispatch($leverancier);
            }
        });

        return redirect()->route('leverancier.index')
            ->with('success', 'Geocoding-taken succesvol gestart!');
    }
}

