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
                'social_email' => \App\Models\Setting::get('social_email'),
                'social_linkedin' => \App\Models\Setting::get('social_linkedin'),
                'social_web' => \App\Models\Setting::get('social_web'),
                'company_address' => \App\Models\Setting::get('company_address'),
                'company_address_size' => \App\Models\Setting::get('company_address_size'),
            ]);
            $view->with('globalMenu', \App\Models\MenuItem::ordered()->active()->get());
        });
    }
}
