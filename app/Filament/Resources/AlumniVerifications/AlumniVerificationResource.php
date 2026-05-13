<?php

namespace App\Filament\Resources\AlumniVerifications;

use App\Filament\Resources\AlumniVerifications\Pages\CreateAlumniVerification;
use App\Filament\Resources\AlumniVerifications\Pages\EditAlumniVerification;
use App\Filament\Resources\AlumniVerifications\Pages\ListAlumniVerifications;
use App\Filament\Resources\AlumniVerifications\Pages\ViewAlumniVerification;
use App\Models\AlumniVerification;
use BackedEnum;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Filament\Support\Colors\Color;
use Filament\Schemas\Components\Section;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Str;

class AlumniVerificationResource extends Resource
{
    protected static ?string $model = AlumniVerification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'alumni_name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Alumni Information')
                ->description('Enter the primary details for institutional verification.')
                ->schema([
                    Forms\Components\TextInput::make('alumni_name')
                        ->label('Full Name')
                        ->required(),
                    Forms\Components\TextInput::make('graduation_year')
                        ->label('Graduation Year')
                        ->required(),
                    Forms\Components\TextInput::make('student_id')
                        ->label('Student ID / Registration')
                        ->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alumni_name')->searchable(),
                Tables\Columns\TextColumn::make('graduation_year'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'flagged',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('risk_score')
                    ->label('Sovereign Risk Score')
                    ->numeric()
                    ->suffix('%')
                    ->weight('bold')
                    ->color(fn (int $state): string => match (true) {
                        $state > 70 => 'danger',
                        $state > 40 => 'warning',
                        default => 'success',
                    })
                    ->description(fn ($record): string => $record->status === 'flagged' ? 'High Risk Detected' : 'Verified Safe'),

                Tables\Columns\TextColumn::make('proof_id')
                    ->label('Midnight ZK-Seal')
                    ->fontFamily('mono')
                    ->limit(10)
                    ->copyable()
                    ->placeholder('Awaiting Seal...')
                    ->tooltip(fn ($record) => $record->proof_id),
            ])
            ->actions([
                // ACTION 1: View Trail (This triggers the Infolist page)
                Action::make('view')
                    ->label('View Trail')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn ($record) => static::getUrl('view', ['record' => $record])),

                // ACTION 2: Sovereign Audit (AI Brain)
                Action::make('audit')
                    ->label('Sovereign Audit')
                    ->icon('heroicon-o-cpu-chip')
                    ->color(Color::Indigo)
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->action(function (AlumniVerification $record) {
                        try {
                            $result = app('agl')->policy('Alumni-Verification')->evaluate([
                                'name' => $record->alumni_name,
                                'year' => $record->graduation_year,
                                'id'   => $record->student_id,
                            ]);

                            $isFlagged = ($result['risk_score'] > 70);
                            
                            $record->update([
                                'status' => $isFlagged ? 'flagged' : 'verified',
                                'risk_score' => $result['risk_score'],
                                'ai_reasoning' => $result['reasoning'],
                                'proof_id' => $result['proof_id'] ?? null,
                            ]);

                            Notification::make()
                                ->title($isFlagged ? 'Audit Flagged' : 'Audit Complete')
                                ->status($isFlagged ? 'warning' : 'success')
                                ->send();

                        } catch (\Exception $e) {
                            Notification::make()->title('Audit Failed')->danger()->send();
                        }
                    }),

                // ACTION 3: View AI Logic (Modal)
                Action::make('view_reasoning')
                    ->label('View AI Logic')
                    ->icon('heroicon-o-document-text')
                    ->color('gray')
                    ->modalWidth('4xl')
                    ->modalHeading('AI Auditor: Analysis & Reasoning')
                    ->modalContent(fn ($record) => new HtmlString(
                        '<div class="prose dark:prose-invert max-w-none">' . 
                        Str::markdown($record->ai_reasoning ?? 'No reasoning available.') . 
                        '</div>'
                    ))
                    ->modalSubmitAction(false),

                // ACTION 4: Verify & Seal (Manager Human-in-the-loop)
                Action::make('manager_approve')
                    ->label('Verify & Seal')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => in_array($record->status, ['flagged', 'pending']))
                    ->requiresConfirmation()
                    ->action(function (AlumniVerification $record) {
                        try {
                            $bridge = app(\ApurbaLabs\AGL\Contracts\AglBridgeInterface::class);
                            $proofId = $bridge->prove(['id' => $record->student_id]);

                            $record->update([
                                'status' => 'verified',
                                'proof_id' => $proofId ?? 'MID-' . bin2hex(random_bytes(8)),
                            ]);

                            Notification::make()->title('Manual Verification Sealed')->success()->send();
                        } catch (\Exception $e) {
                            $record->update([
                                'status' => 'verified',
                                'proof_id' => 'MOCK-' . Str::random(10),
                            ]);
                            Notification::make()->title('Sealed with Local Proof')->warning()->send();
                        }
                    }),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identity Verification')
                ->icon('heroicon-o-user')
                ->schema([
                    TextEntry::make('alumni_name')->label('Full Name')->weight('bold'),
                    TextEntry::make('graduation_year')->label('Class Of'),
                    TextEntry::make('student_id')->label('Institutional ID'),
                ])->columns(3),

            Section::make('Sovereign Governance Status')
                ->icon('heroicon-o-shield-check')
                ->schema([
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending'  => 'gray',
                            'flagged'  => 'warning',
                            'verified' => 'success',
                            'rejected' => 'danger',
                            default    => 'gray',
                        }),
                    TextEntry::make('risk_score')->label('AI Risk')->suffix('%')->weight('bold'),
                    TextEntry::make('proof_id')->label('Midnight Seal')->fontFamily('mono')->copyable(),
                ])->columns(3),

            Section::make('Audit & Compliance Trail')
                ->schema([
                    TextEntry::make('ai_reasoning')
                        ->label('Initial AI Auditor Logic')
                        ->markdown()
                        ->prose()
                        ->columnSpanFull()
                        ->hint('Generated via Gemma-2'),
                    
                    TextEntry::make('proof_id')
                        ->label('Final Institutional Seal')
                        ->weight('bold')
                        ->color('success')
                        ->hint('Manually Verified by Manager'),
                ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAlumniVerifications::route('/'),
            'create' => CreateAlumniVerification::route('/create'),
            'view'   => ViewAlumniVerification::route('/{record}'),
            'edit'   => EditAlumniVerification::route('/{record}/edit'),
        ];
    }
}