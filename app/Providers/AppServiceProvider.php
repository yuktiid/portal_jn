<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
// use Illuminate\Support\Facades\Cache;
// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Agar pagination bootstrap jalan (biasanya di laravel 8)
        Paginator::useBootstrap();

        $imgUrl = config('services.jurnalnusa.base_url');
        $baseUrl = config('services.jurnalnusa.base_url');
        
        // Share ke semua view
        View::share('imgUrl', $imgUrl);
        // -------------------------
        
    }
}