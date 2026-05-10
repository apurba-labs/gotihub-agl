<?php

namespace App\Filament\Resources\ShieldedTransactions\Pages;

use App\Filament\Resources\ShieldedTransactions\ShieldedTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewShieldedTransaction extends ViewRecord
{
    protected static string $resource = ShieldedTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
