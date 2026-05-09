<?php

namespace App\Filament\Widgets;

use App\Services\DnaService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DnaHealthStats extends StatsOverviewWidget
{
    /**
     * Dependency injection via the method to pull real-time governance metrics.
     */
    protected function getStats(): array
    {
        $service = app(DnaService::class);

        return [
            Stat::make('DNA Chain Integrity', $service->getChainIntegrity() . '%')
                ->description('Linked to Batch 1970-2026')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Pending AI Audits', '12')
                ->description('Gemma 4 processing...')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('warning'),

            Stat::make('ZK-Verified Events', number_format($service->getVerifiedCount()))
                ->description('Midnight Network Secured')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'),
        ];
    }
}