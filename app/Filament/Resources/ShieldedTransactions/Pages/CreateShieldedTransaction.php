<?php

namespace App\Filament\Resources\ShieldedTransactions\Pages;

use App\Filament\Resources\ShieldedTransactions\ShieldedTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShieldedTransaction extends CreateRecord
{
    protected static string $resource = ShieldedTransactionResource::class;
}
