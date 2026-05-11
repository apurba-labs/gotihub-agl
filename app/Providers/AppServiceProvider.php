<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ai\Agents\InstitutionalAuditor;
use ApurbaLabs\AGL\Contracts\AglAuditor;
use ApurbaLabs\AGL\Contracts\ZkVerifier;
use App\Services\Midnight\MidnightService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ZkVerifier::class, 
            MidnightService::class
        );

        $this->app->bind(AglAuditor::class, InstitutionalAuditor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
