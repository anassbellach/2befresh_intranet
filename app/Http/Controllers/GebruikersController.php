<?php

namespace App\Http\Controllers;


use App\Mail\UserRegisteredMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GebruikersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_id', 'like', "%$search%")
                    ->orWhere('user_firstname', 'like', "%{$search}%")
                    ->orWhere('user_lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('user_rol', 'like', "%{$search}%")
                    ->orWhere('user_activated', 'like', "%{$search}%")
                    ->orWhereRaw("IF(deleted_at === null, 'actief', 'inactief') LIKE ?", ["%{$search}%"]);            });
        }

        // Sorting functionality
        $sortKey = $request->get('sortKey', 'user_id'); // Default sort key
        $sortOrder = $request->get('sortOrder', 'asc');    // Default sort order
        $query->orderBy($sortKey, $sortOrder);


        // Paginate the results
        $gebruikers = $query->paginate(10);

        return inertia('Gebruikers/Index', [
            'gebruikers' => $gebruikers,
            'filters' => [
                'search' => $request->get('search', ''),
                'sortKey' => $sortKey,
                'sortOrder' => $sortOrder,
            ],
        ]);
    }

    public function create()
    {
        return inertia('Gebruikers/Create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'email' => 'required|email|max:255|unique:admin,email',
            'user_firstname' => 'required|string|max:255',
            'user_lastname' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'user_activated' => 'nullable|boolean',
            'user_activation_code' => 'nullable|string|max:255',
            'user_rol' => 'required|string|max:255',
        ]));

        Auth::login($user);
//        event(new Registered($user));

        // Send the styled email
        Mail::to($user->email)->send(new UserRegisteredMail($user));

        return redirect()->route('gebruiker.index')
            ->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    public function show(User $gebruiker)
    {
        return inertia('Gebruikers/Show', [
            'gebruiker' => $gebruiker
        ]);
    }

    public function edit(User $gebruiker)
    {
        return inertia('Gebruikers/Edit', [
            'gebruiker' => $gebruiker
        ]);
    }

    public function update(Request $request, User $gebruiker)
    {
        $gebruiker->update(
            $request->validate([
                'email' => 'required|email|max:255|',
                'user_firstname' => 'required|string|max:255',
                'user_lastname' => 'required|string|max:255',
                'password' => 'nullable|string|min:8',
                'user_activated' => 'nullable|boolean',
                'user_rol' => 'required|string|max:255',
            ])
        );
        return redirect()->route('gebruiker.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    public function destroy(User $gebruiker)
    {
        $gebruiker->deleteOrFail();
        return redirect()->route('gebruiker.index')
            ->with('success', 'Gebruiker succesvol verwijderd!');
    }

    public function restore(User $gebruiker)
    {
        $gebruiker->restore();
        return redirect()->route('gebruiker.index')
            ->with('success', 'Gebruiker succesvol hersteld!');
    }
}
