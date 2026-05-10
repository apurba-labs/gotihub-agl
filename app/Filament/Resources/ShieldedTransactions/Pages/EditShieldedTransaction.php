<?php

namespace App\Filament\Resources\ShieldedTransactions\Pages;

use App\Filament\Resources\ShieldedTransactions\ShieldedTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditShieldedTransaction extends EditRecord
{
    protected static string $resource = ShieldedTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
