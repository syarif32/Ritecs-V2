<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


use App\Models\Setting;
use App\Models\Frontend\Footer\FooterGallery;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        
        View::composer(['partials.footer', 'partials.navbar'], function ($view) { 
            $view->with([
                'footer_address' => Setting::where('key', 'contact_address')->first(),
                'footer_email' => Setting::where('key', 'contact_email')->first(),
                'footer_phone' => Setting::where('key', 'contact_phone')->first(),
                'footer_instagram_title' => Setting::where('key', 'footer_instagram_title')->first(),
                'social_facebook' => Setting::where('key', 'social_facebook')->first(),
                'social_twitter' => Setting::where('key', 'social_twitter')->first(),
                'social_instagram' => Setting::where('key', 'social_instagram')->first(),
                'social_linkedin' => Setting::where('key', 'social_linkedin')->first(),
                'footer_galleries' => FooterGallery::latest()->take(6)->get(),
                'navbar_phone' => Setting::where('key', 'contact_phone')->first(),
            ]);
        });
        View::composer(['partials.footer', 'partials.navbar', 'partials.header'], function ($view) { 
        $view->with([
        'footer_address' => Setting::where('key', 'contact_address')->first(),
        'footer_email' => Setting::where('key', 'contact_email')->first(),
        'footer_phone' => Setting::where('key', 'contact_phone')->first(),
        'footer_instagram_title' => Setting::where('key', 'footer_instagram_title')->first(),
        'social_facebook' => Setting::where('key', 'social_facebook')->first(),
        'social_twitter' => Setting::where('key', 'social_twitter')->first(),
        'social_instagram' => Setting::where('key', 'social_instagram')->first(),
        'social_linkedin' => Setting::where('key', 'social_linkedin')->first(),
        'footer_galleries' => \App\Models\Frontend\Footer\FooterGallery::latest()->take(6)->get(),
        'navbar_phone' => Setting::where('key', 'contact_phone')->first(),
    ]);
});
    }
}