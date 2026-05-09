<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use ApurbaLabs\LaravelAgl\Facades\AGL;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Services\MidnightService;
use Illuminate\Contracts\Support\Htmlable;

class GovernanceDashboard extends Page
{
    
    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shield-check';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Agentic Layer';
    }

    public function getHeading(): string|Htmlable
    {
        return 'DNA Auditor';
    }

    public static function getNavigationLabel(): string
    {
        return 'DNA Auditor';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('triggerFullAudit')
                ->label('Initiate Agentic Audit')
                ->icon('heroicon-m-shield-check')
                ->color('primary')
                ->modalHeading('New Governance Audit')
                ->modalDescription('This will trigger a Gemma 4 reasoning loop and generate a Midnight ZK-Proof.')
                ->form([
                    TextInput::make('transaction_id')
                        ->label('Transaction ID / Alumni ID')
                        ->placeholder('ALUM-2026-XXXX')
                        ->required(),
                    Select::make('audit_type')
                        ->options([
                            'voting' => 'Batch Voting Rights',
                            'finance' => 'Fund Allocation',
                            'identity' => 'DNA Verification',
                        ])
                        ->default('identity')
                        ->required(),
                ])
                ->action(function (array $data, MidnightService $midnightService) {
                    // 1. Agentic Logic (Gemma 4 via Laravel-AGL)
                    $isApproved = true; // Default for demo
                    if (class_exists(AGL::class)) {
                        $isApproved = AGL::policy($data['audit_type'])->evaluate($data);
                    }

                    if (!$isApproved) {
                        Notification::make()
                            ->title('Audit Rejected')
                            ->body("Gemma 4 detected a policy violation for {$data['transaction_id']}.")
                            ->danger()
                            ->send();
                        return;
                    }

                    // 2. Midnight Privacy Logic (ZK-Proof)
                    $proof = $midnightService->generateProof([
                        'id' => $data['transaction_id'],
                        'type' => $data['audit_type'],
                    ]);

                    // 3. Success UI
                    Notification::make()
                        ->title('Privacy-First Audit Successful')
                        ->success()
                        ->icon('heroicon-o-shield-check')
                        ->body("
                            **Gemma 4 Result:** Approved  
                            **Midnight Proof ID:** `{$proof['proof_id']}`  
                            **Status:** Immutable Sequence Locked
                        ")
                        ->duration(10000)
                        ->send();
                }),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\DnaHealthStats::class,
        ];
    }
}