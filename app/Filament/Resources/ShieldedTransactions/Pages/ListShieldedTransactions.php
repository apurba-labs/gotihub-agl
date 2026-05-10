<?php

namespace App\Filament\Resources\ShieldedTransactions\Pages;

use App\Filament\Resources\ShieldedTransactions\ShieldedTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShieldedTransactions extends ListRecords
{
    protected static string $resource = ShieldedTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
