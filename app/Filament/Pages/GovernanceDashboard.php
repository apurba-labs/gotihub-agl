<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use ApurbaLabs\LaravelAgl\Facades\AGL;

class GovernanceDashboard extends Page
{
    protected string $view = 'filament.pages.governance-dashboard';


    public function auditAction(): Action
    {
        return Action::make('runAudit')
            ->label('Run DNA Audit')
            ->icon('heroicon-m-bolt')
            ->color('success')
            ->action(function () {
                // This is where we call your package code!
                $result = AGL::policy('alumni-dna-check')->evaluate(['test' => 'data']);
                
                Notification::make()
                    ->title($result ? 'DNA Sequence Verified' : 'Audit Failed')
                    ->success()
                    ->send();
            });
    }
}
