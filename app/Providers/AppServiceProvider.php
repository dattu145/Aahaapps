<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $view->with('globalSettings', [
                'logo' => \App\Models\Setting::get('logo'),
                'logo_url' => \App\Models\Setting::get('logo_url'),
                'logo_width' => \App\Models\Setting::get('logo_width'),
                'logo_height' => \App\Models\Setting::get('logo_height'),
                'whatsapp_number' => \App\Models\Setting::get('whatsapp_number'),
            ]);
            $view->with('globalMenu', \App\Models\MenuItem::ordered()->active()->get());
        });
    }
}
