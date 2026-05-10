<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\Support\Htmlable;
use App\Models\AuditLog;
use App\Services\ReasoningService;
use App\Services\ApprovalEngine;
use App\Services\MidnightService;

class GovernanceDashboard extends Page
{
    protected static string $view = 'filament.pages.governance-dashboard';

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
                ->action(function (array $data, ReasoningService $aiService, ApprovalEngine $engine, MidnightService $midnightService) {
                    
                    // 1. Initial Logging - IAM Check
                    AuditLog::create([
                        'event_type' => 'IAM',
                        'message' => "Request initiated for {$data['transaction_id']} by " . auth()->user()->name,
                        'status' => 'info'
                    ]);

                    try {
                        // 2. Call the Gemma Bridge (via Service)
                        $aiResult = $aiService->analyzeTransaction($data['transaction_id'], $data['audit_type']);

                        // 3. Log every 'Thought' from the Multi-Agent Loop
                        foreach ($aiResult['reasoning'] as $thought) {
                            AuditLog::create([
                                'event_type' => 'AI',
                                'message' => $thought,
                                'status' => 'success'
                            ]);
                        }

                        // 4. Handle the AI Decision
                        if ($aiResult['decision'] !== 'APPROVED') {
                            $engine->flagForReview($data['transaction_id'], 'AI_REJECTION');
                            
                            Notification::make()
                                ->title('Audit Rejected by Gemma 4')
                                ->danger()
                                ->send();
                            return;
                        }

                        // 5. SUCCESS: Update Approval Engine Status
                        $engine->processApproval($data['transaction_id'], 'AI_VERIFIED');

                        // 6. Final Step: Proceed to Midnight ZK-Proof
                        $proof = $midnightService->generateProof($data);

                        AuditLog::create([
                            'event_type' => 'ZK',
                            'message' => "Midnight Proof Generated: {$proof['proof_id']}",
                            'status' => 'success'
                        ]);

                        Notification::make()
                            ->title('Privacy-First Audit Successful')
                            ->success()
                            ->body("Decision: **Approved** | ZK-Proof: `{$proof['proof_id']}`")
                            ->send();

                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('System Error')
                            ->body($e->getMessage())
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
}