<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }


    public function boot(): void
    {
        if(str_contains(request()->url(), 'ngrok-free.app')){
            URL::forceScheme('https');
        }
    }
}
