<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Klant;
use App\Models\Leverancier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;

        // Function to get counts for the current year
        $getCurrentYearCount = fn($model) => $model::whereRaw('YEAR(FROM_UNIXTIME(created_at)) = ?', [$currentYear])->count();

        return inertia('Dashboard/Index', [
            'klanten_count' => Klant::count(),
            'klanten_NewThisYear' => $getCurrentYearCount(Klant::class),
            'leveranciers_count' => Leverancier::count(),
            'leveranciers_NewThisYear' => $getCurrentYearCount(Leverancier::class),
            'contacten_count' => Contact::count(),
            'contacten_NewThisYear' => $getCurrentYearCount(Contact::class),
            'klanten_growth_by_year' => Klant::selectRaw("YEAR(FROM_UNIXTIME(created_at)) as year, COUNT(*) as count")
                ->groupBy('year')
                ->orderBy('year')
                ->pluck('count', 'year'),
        ]);
    }
}
