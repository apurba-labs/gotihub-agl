<?php

namespace App\Filament\Resources\ShieldedTransactions\Schemas;

use App\Models\ShieldedTransaction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ShieldedTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('proof_id'),
                TextEntry::make('merkle_root'),
                TextEntry::make('transaction_id_hash'),
                TextEntry::make('network'),
                TextEntry::make('status'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ShieldedTransaction $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
