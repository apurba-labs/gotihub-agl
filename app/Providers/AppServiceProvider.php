<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ai\Agents\InstitutionalAuditor;
use ApurbaLabs\AGL\Contracts\AglAuditor;
use ApurbaLabs\AGL\Contracts\ZkVerifier;
use App\Services\Midnight\MidnightService;
use ApurbaLabs\AGL\Services\RemoteAglBridge;
use ApurbaLabs\AGL\Contracts\AglBridgeInterface;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

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
        FilamentView::registerRenderHook(
            'panels::auth.login.form.after',
            fn (): string => Blade::render('
                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm">
                    <p class="font-bold text-primary-600">Demo Access:</p>
                    <p><strong>User:</strong> apurbansinghdev@gmail.com</p>
                    <p><strong>Pass:</strong> Mid@Night@day@026</p>
                </div>
            '),
        );
    }
}
