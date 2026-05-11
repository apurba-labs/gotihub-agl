<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ai\Agents\InstitutionalAuditor;
use ApurbaLabs\AGL\Contracts\AglAuditor;
use ApurbaLabs\AGL\Contracts\ZkVerifier;
use App\Services\Midnight\MidnightService;
use ApurbaLabs\AGL\Services\RemoteAglBridge;
use ApurbaLabs\AGL\Contracts\AglBridgeInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MidnightService::class);
        
        $this->app->bind(ZkVerifier::class, MidnightService::class);
        $this->app->bind(AglBridgeInterface::class, MidnightService::class);

        $this->app->bind(AglAuditor::class, InstitutionalAuditor::class);

        $this->app->bind(AglBridgeInterface::class, function ($app) {
            return new RemoteAglBridge(
                url: config('services.midnight.bridge_url'),
                networkName: 'Midnight-Devnet-v1'
            );
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
