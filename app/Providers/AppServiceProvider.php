<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use App\Models\Property;
use App\Observers\PropertyObserver;

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
        Property::observe(PropertyObserver::class);

        // Ensure $errors is always available in views
    View::composer('*', function ($view) {
        if (!session()->has('errors')) {
            session()->flash('errors', new ViewErrorBag()); // Ensure it's a ViewErrorBag
        }
        $view->with('errors', session('errors'));
    });
    }
}
