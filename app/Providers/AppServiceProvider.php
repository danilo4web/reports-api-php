<?php

namespace App\Providers;

use App\Adapter\CsvFileGeneratorAdapter;
use App\Adapter\FileGeneratorAdapterInterface;
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
        $this->app->bind(FileGeneratorAdapterInterface::class, CsvFileGeneratorAdapter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
