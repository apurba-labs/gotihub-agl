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
                    try {
                        // 1. Execute the AGL Governance Loop
                        $result = $agl->policy('Institutional-Alumni-Verification')
                                    ->requireZkProof()
                                    ->evaluate(['id' => $data['transaction_id']]);

                        // 2. Log the AI Reasoning (Scannable for the UI)
                        AuditLog::create([
                            'event_type' => 'AI_AUDIT',
                            'message'    => $result['reasoning'],
                            'status'     => $result['approved'] ? 'success' : 'warning'
                        ]);

                        if ($result['approved']) {
                            /** * 3. Save to Ledger
                             * Using the top-level 'proof_id' we just added to the package,
                             * but falling back to the 'proof' array for the details.
                             */
                            ShieldedTransaction::create([
                                'proof_id'            => $result['proof_id'], // Top-level shortcut
                                'merkle_root'         => $result['proof']['merkle_root'] ?? 'N/A',
                                'transaction_id_hash' => hash('sha256', $data['transaction_id']),
                                'network'             => $result['proof']['network'] ?? 'Midnight-Mainnet',
                                'status'              => 'shielded',
                            ]);

                            Notification::make()
                                ->title('Sovereign Verification Successful')
                                ->body("Proof ID: {$result['proof_id']}") // Show the ID to the client!
                                ->success()
                                ->send();
                        } else {
                            // 4. Handle Rejections (AGL or Strict Policy)
                            Notification::make()
                                ->title('Verification Rejected by AGL')
                                ->body($result['decision'] === 'REJECTED_BY_STRICT_POLICY' 
                                    ? 'Flagged by Strict Risk Score Threshold.' 
                                    : 'AI Agent declined the verification.')
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