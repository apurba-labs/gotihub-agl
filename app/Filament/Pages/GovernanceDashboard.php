<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\Support\Htmlable;
use App\Models\AuditLog;
use App\Models\ShieldedTransaction;
use App\Services\ReasoningService;
use App\Services\ApprovalEngine;
use App\Services\Midnight\MidnightService;
use ApurbaLabs\AGL\Services\GovernanceManager;

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
                ->form([
                    TextInput::make('transaction_id')
                        ->label('Transaction ID / Alumni ID')
                        ->required(),
                ])
                ->action(function (array $data, GovernanceManager $agl) {
                    // This is the bridge! We call the package directly here.
                    
                    // 1. Initial Log
                    AuditLog::create([
                        'event_type' => 'IAM',
                        'message' => "Request initiated for {$data['transaction_id']}",
                        'status' => 'info'
                    ]);

                    try {
                        // 2. Run the Package Policy
                        $result = $agl->policy('Institutional-Alumni-Verification')
                            ->requireZkProof()
                            ->evaluate(['id' => $data['transaction_id']]);

                        // 3. Log the AI Reasoning to the UI Feed
                        AuditLog::create([
                            'event_type' => 'AI',
                            'message' => $result['reasoning'],
                            'status' => $result['approved'] ? 'success' : 'warning'
                        ]);

                        if ($result['approved']) {
                            // 4. Save to Ledger (The ZK Proof is in $result['proof'])
                            ShieldedTransaction::create([
                                'proof_id' => $result['proof']['proof_id'],
                                'merkle_root' => $result['proof']['merkle_root'],
                                'transaction_id_hash' => hash('sha256', $data['transaction_id']),
                                'network' => $result['proof']['network'],
                                'status' => 'shielded',
                            ]);

                            Notification::make()
                                ->title('Sovereign Verification Successful')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Verification Rejected by AGL')
                                ->danger()
                                ->send();
                        }

                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('AGL Service Error')
                            ->body($e->getMessage()) // Likely "Connection Refused" if Ollama is off
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\DnaHealthStats::class,
            \App\Filament\Widgets\AuditFeed::class, // Added your new feed here!
        ];
    }

    public function startAudit(GovernanceManager $agl)
    {
        $result = $agl->policy('Alumni-Verification')
                    ->requireZkProof()
                    ->evaluate(['id' => $this->transaction_id]);

        if ($result['approved']) {
            // We have the REAL proof data from the package!
            $this->saveToShieldedLedger($result);
            
            Notification::make()->title('Sovereign Verification Successful')->success()->send();
        } else {
            Notification::make()->title('Verification Rejected')->danger()->send();
        }
    }
}