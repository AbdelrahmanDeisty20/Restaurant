<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Offer;
use App\Models\Order;
use App\Observers\OfferObserver;
use App\Observers\OrderObserver;


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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        \App\Models\Offer::observe(\App\Observers\OfferObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Contact::observe(\App\Observers\ContactObserver::class);
    }
}
