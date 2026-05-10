<?php

namespace App\Filament\Resources\ShieldedTransactions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ShieldedTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('proof_id')
                    ->required(),
                TextInput::make('merkle_root')
                    ->required(),
                TextInput::make('transaction_id_hash')
                    ->required(),
                TextInput::make('network')
                    ->required()
                    ->default('Midnight Testnet'),
                TextInput::make('status')
                    ->required()
                    ->default('shielded'),
            ]);
    }
}
