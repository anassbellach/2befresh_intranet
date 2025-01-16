<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Http\Request;

class LeveranciersMapController extends Controller
{
    public function index()
    {

        return inertia('Leveranciers/Kaart/Index', [
            'leveranciers' => Leverancier::withTrashed()->get(),
        ]);
    }
}
