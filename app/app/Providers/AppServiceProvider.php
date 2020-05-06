<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::component('components.formfield', 'field');
        Blade::component('components.numformfield', 'numfield');
        Blade::component('components.selectfield', 'select');
        Blade::component('components.inputspinner', 'inputspinner');
    }
}
