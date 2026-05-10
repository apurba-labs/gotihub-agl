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
use Illuminate\Support\Facades\Http;
use App\Models\AuditLog;

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
                    
                    // Handshake with the Gemma 4 Bridge
                    AuditLog::create([
                        'event_type' => 'AI',
                        'message' => "Requesting Agentic Reasoning for {$data['transaction_id']}...",
                        'status' => 'info'
                    ]);

                    try {
                        $response = Http::timeout(30)->post('http://localhost:8001/api/v1/audit', [
                            'transaction_id' => $data['transaction_id'],
                            'audit_type' => $data['audit_type'],
                            'metadata' => [
                                'actor_id' => auth()->id(),
                                'platform' => 'GotiHub-AGL'
                            ]
                        ]);

                        if ($response->failed()) {
                            throw new \Exception("AI Bridge Unreachable");
                        }

                        $result = $response->json();

                        // Log every 'Thought' from the Multi-Agent Loop
                        foreach ($result['reasoning'] as $thought) {
                            AuditLog::create([
                                'event_type' => 'AI',
                                'message' => $thought,
                                'status' => 'success'
                            ]);
                        }

                        if ($result['decision'] !== 'APPROVED') {
                            Notification::make()->title('Audit Rejected by Gemma 4')->danger()->send();
                            return;
                        }

                        // Proceed to Midnight ZK-Proof
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
                        Notification::make()->title('System Error')->body($e->getMessage())->danger()->send();
                    }
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