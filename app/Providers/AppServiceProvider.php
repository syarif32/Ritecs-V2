<?php
namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

       
        if (Schema::hasTable('settings')) {
            try {
               
                $global_settings = Setting::all()->pluck('value', 'key');
                
               
                View::share('global_settings', $global_settings);

            } catch (\Exception $e) {
               
                View::share('global_settings', []);
            }
        }
    }
}