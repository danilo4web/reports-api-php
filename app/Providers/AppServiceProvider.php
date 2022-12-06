<?php

namespace App\Providers;

use App\Adapter\CsvFileGeneratorAdapter;
use App\Adapter\FileGeneratorAdapterInterface;
use App\Services\ReportService;
use App\Services\ReportServiceInterface;
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
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
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
