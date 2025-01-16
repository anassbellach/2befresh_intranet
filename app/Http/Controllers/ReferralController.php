<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = Referral::withTrashed();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('titel', 'like', "%$search%")
                    ->orWhere('omschrijving', 'like', "%$search%")
                    ->orWhere('link', 'like', "%$search%")
                    ->orWhere('referral_activated', 'like', "%$search%")
                    ->orWhereRaw('IF(referral_activated = 1, "actief", "inactief") like ?', ["%$search%"]);
            });
        }

        $referrals = $query->paginate(9);

        return inertia('Referrals/Index', [
            'referrals' => $referrals,
            'filters' => [
                'search' => $request->get('search', ''),
            ],
        ]);
    }


    public function create()
    {
        return inertia('Referrals/Create');
    }

    public function store(Request $request)
    {
        Referral::create(
            $request->validate([
                'titel' => 'required|string|max:255',
                'omschrijving' => 'required|string|max:255',
                'link' => 'required|string|max:255',
                'referral_activated' => 'required|boolean',
            ])
        );

        return redirect()->route('referral.index')
            ->with('success', 'Referral succesvol aangemaakt!');
    }

    public function show(Referral $referral)
    {
        return inertia('Referrals/Show', [
            'referral' => $referral
        ]);
    }

    public function edit(Referral $referral)
    {
        return inertia('Referrals/Edit', [
            'referral' => $referral
        ]);
    }

    public function update(Request $request, Referral $referral)
    {
        $referral->update(
            $request->validate([
                'titel' => 'required|string|max:255',
                'omschrijving' => 'required|string|max:255',
                'link' => 'required|string|max:255',
                'referral_activated' => 'required|boolean',
            ])
        );

        return redirect()->route('referral.index')
            ->with('success', 'Referral succesvol bijgewerkt!');
    }

    public function destroy(Referral $referral)
    {
        $referral->deleteOrFail();

        return redirect()->route('referral.index')
            ->with('success', 'Referral succesvol verwijderd!');
    }

    public function restore(Referral $referral)
    {
        $referral->restore();

        return redirect()->route('referral.index')
            ->with('success', 'Referral succesvol hersteld!');
    }
}
