<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => $request->user() ? [
                'id' => $request->user()->user_id,
                'email' => $request->user()->user_email,
                'fullName' => $request->user()->user_firstname . ' ' . $request->user()->user_lastname,
                'role' => $request->user()->user_rol, // Add the user role
                'activated' => $request->user()->user_activated, // Include activated status
            ] : null,

            'flash' => [
                'success' => $request->session()->get('success'),
            ]
        ]);
    }
}