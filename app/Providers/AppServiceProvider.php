<?php

namespace App\Providers;

use App\Http\Services\DailyTimeRecordService;
use App\Http\Services\DailyTimeRecordServiceTest;
use App\Http\Services\DailyTimeRecordServiceTest1;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DailyTimeRecordService::class, function ($app){
            return new DailyTimeRecordService();
        });

        $this->app->singleton(DailyTimeRecordServiceTest::class, function ($app){
            return new DailyTimeRecordServiceTest();
        });

        $this->app->singleton(DailyTimeRecordServiceTest1::class, function ($app){
            return new DailyTimeRecordServiceTest1();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
