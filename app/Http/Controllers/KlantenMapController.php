<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;

class KlantenMapController extends Controller
{
    public function index()
    {

        return inertia('Klanten/Kaart/Index', [
            'klanten' => Klant::all()
        ]);
    }
}

