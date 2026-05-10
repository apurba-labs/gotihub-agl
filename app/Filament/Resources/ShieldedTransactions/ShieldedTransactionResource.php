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
        return ShieldedTransactionsTable::configure($table);
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
