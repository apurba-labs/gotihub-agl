<?php

namespace App\Filament\Resources\ShieldedTransactions;

use App\Filament\Resources\ShieldedTransactions\Pages\CreateShieldedTransaction;
use App\Filament\Resources\ShieldedTransactions\Pages\EditShieldedTransaction;
use App\Filament\Resources\ShieldedTransactions\Pages\ListShieldedTransactions;
use App\Filament\Resources\ShieldedTransactions\Pages\ViewShieldedTransaction;
use App\Filament\Resources\ShieldedTransactions\Schemas\ShieldedTransactionForm;
use App\Filament\Resources\ShieldedTransactions\Schemas\ShieldedTransactionInfolist;
use App\Filament\Resources\ShieldedTransactions\Tables\ShieldedTransactionsTable;
use App\Models\ShieldedTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;

class ShieldedTransactionResource extends Resource
{
    protected static ?string $model = ShieldedTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'proof_id';

    public static function form(Schema $schema): Schema
    {
        return ShieldedTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ShieldedTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. The ZK-Proof (Monospaced & Copyable)
                TextColumn::make('proof_id')
                    ->label('Shielded Proof')
                    ->fontFamily('mono') // Looks like code/blockchain data
                    ->copyable() // Clicking copies the ID
                    ->copyMessage('Proof ID copied!')
                    ->color('primary')
                    ->weight('bold')
                    ->searchable(),

                // 2. Merkle Root (Truncated for clean look)
                TextColumn::make('merkle_root')
                    ->label('Merkle Root')
                    ->fontFamily('mono')
                    ->limit(16)
                    ->color('gray')
                    ->tooltip(fn ($state) => $state), // Show full root on hover

                // 3. Network Badge
                TextColumn::make('network')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-globe-alt'),

                // 4. Status with a Pulse/Dot
                TextColumn::make('status')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->icon('heroicon-m-shield-check'),

                // 5. Time Since Verification
                TextColumn::make('created_at')
                    ->label('Verified At')
                    ->dateTime('Y-m-d H:i')
                    ->since() // Shows "2 mins ago" - very 'live' feel
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc') // Newest proofs at the top
           ->filters([
                TrashedFilter::make(), // Much cleaner!
            ])
            ->actions([
                ViewAction::make()
                    ->label('Explore')
                    ->icon('heroicon-m-magnifying-glass-circle')
                    ->color('success')
                    ->url(fn ($record): string => static::getUrl('view', ['record' => $record])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShieldedTransactions::route('/'),
            'create' => CreateShieldedTransaction::route('/create'),
            'view' => ViewShieldedTransaction::route('/{record}'),
            'edit' => EditShieldedTransaction::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
