<?php

namespace App\Filament\Widgets;

use App\Models\AuditLog;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class AuditFeed extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => AuditLog::query())
            ->columns([
                TextColumn::make('created_at')->label('Time')->dateTime('H:i:s')->color('gray'),
                TextColumn::make('event_type')
                    ->label('Layer')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'AI' => 'warning',
                        'ZK' => 'primary',
                        'IAM' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('message')->label('Reasoning / Action')->wrap(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'danger' => 'danger',
                        'warning' => 'warning',
                        default => 'info',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //BulkActionGroup::make([
                    //
                //]),
            ]),
            ->poll('3s');
    }
}
