<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobRepository::class, function ($app) {
            return new JobRepository(new \App\Models\Job);
        });
    
        $this->app->bind(JobService::class, function ($app) {
            return new JobService($app->make(JobRepository::class));
        });

        $this->app->bind(ApplicationRepository::class, function ($app) {
            return new ApplicationRepository(new \App\Models\Application);
        });
    
        $this->app->bind(ApplicationService::class, function ($app) {
            return new ApplicationService($app->make(ApplicationRepository::class));
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
