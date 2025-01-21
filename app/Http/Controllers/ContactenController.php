<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactenController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::withTrashed();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contact_id', 'like', "%$search%")
                    ->orWhere('contact_naam', 'like', "%$search%")
                    ->orWhere('contact_telefoon', 'like', "%$search%")
                    ->orWhere('contact_mail', 'like', "%$search%")
                    ->orWhereRaw('IF(deleted_at === null, "actief", "inactief") like ?', ["%$search%"]);
            });
        }

        // Sorting functionality
        $sortKey = $request->get('sortKey', 'contact_id');
        $sortOrder = $request->get('sortOrder', 'asc');
        $query->orderBy($sortKey, $sortOrder);

        // Paginate the results
        $contacten = $query->paginate(10);

        return inertia('Contacten/Index', [
            'contacten' => $contacten,
            'filters' => [
                'search' => $request->get('search', ''),
                'sortKey' => $sortKey,
                'sortOrder' => $sortOrder,
            ],
        ]);
    }


    public function create()
    {
        return inertia('Contacten/Create');
    }

    public function store(Request $request)
    {

        Contact::create(
            $request->validate([
                'contact_naam' => 'required|string|max:255',
                'contact_geboortedatum' => 'nullable|date',
                'contact_geslacht' => 'nullable|string|max:10',
                'contact_telefoon' => 'required|string|max:17',
                'contact_telefoon_kantoor' => 'nullable|string|max:17',
                'contact_mail' => 'required|email|max:255',
                'contact_mail_2' => 'nullable|email|max:255',
                'contact_mail_3' => 'nullable|email|max:255',
                'contact_voorkeur' => 'nullable|string|max:255',
                'contact_actief' => 'required|boolean',
            ])
        );

        return redirect()->route('contact.index')
            ->with('success', 'Contact succesvol aangemaakt!');
    }

    public function show(Contact $contact)
    {
        return inertia('Contacten/Show',[
            'contact' => $contact
        ]);
    }

    public function edit(Contact $contact)
    {
        return inertia('Contacten/Edit',
            [
                'contact' => $contact
            ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $contact->update(
            $request->validate([
                'contact_naam' => 'required|string|max:255',
                'contact_geboortedatum' => 'nullable|date',
                'contact_geslacht' => 'nullable|string|max:10',
                'contact_telefoon' => 'required|string|max:17',
                'contact_telefoon_kantoor' => 'nullable|string|max:17',
                'contact_mail' => 'required|email|max:255',
                'contact_mail_2' => 'nullable|email|max:255',
                'contact_mail_3' => 'nullable|email|max:255',
                'contact_voorkeur' => 'nullable|string|max:255',
            ])
        );

        return redirect()->route('contact.index')
            ->with('success', 'Contact succesvol bijgewerkt!');
    }

    public function destroy(Contact $contact)
    {
        $contact->deleteOrFail();

        return redirect()->route('contact.index')
            ->with('success', 'Contact succesvol verwijderd!');
    }

    public function restore(Contact $contact)
    {
        $contact->restore();

        return redirect()->route('contact.index')
            ->with('success', 'Contact succesvol hersteld!');
    }
}
