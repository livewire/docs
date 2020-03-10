<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Blade::component('components.code', 'code');
        // Blade::component('components.code-component', 'codeComponent');
        // Blade::component('components.warning', 'warning');
        // Blade::component('components.tip', 'tip');
        // Blade::component('components.table', 'table');
    }
}
