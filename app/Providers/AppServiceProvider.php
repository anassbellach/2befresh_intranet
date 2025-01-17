<?php

namespace App\Providers;

use App\Models\Klant;
use App\Policies\KlantPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Klant::class, KlantPolicy::class);
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

