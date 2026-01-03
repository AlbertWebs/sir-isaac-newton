<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Added
use App\Models\SchoolInformation; // Added

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
        // Fix MySQL key length issue with utf8mb4
        // Set default string length to 191 to avoid "Specified key was too long" errors
        Schema::defaultStringLength(191);

        // View Composer for website layout
        View::composer('layouts.website', function ($view) {
            $schoolInfo = SchoolInformation::where('status', 'active')->first();
            $view->with('schoolInfoForLayout', $schoolInfo);
        });

        // View Composer for admin settings page
        View::composer('settings.index', function ($view) {
            $schoolInfo = SchoolInformation::firstOrCreate([]);
            $view->with('schoolInfo', $schoolInfo);
        });
    }
}
