<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer(['layouts.deanSidebar', 'layouts.chairSidebar'], function ($view) {
            $user = Auth::user();
            $notifications = $user ? $user->notifications : collect();
            $view->with('notifications', $notifications);
        });
    }
}
