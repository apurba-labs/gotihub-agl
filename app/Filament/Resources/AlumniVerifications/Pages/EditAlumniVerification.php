<?php

namespace App\Filament\Resources\AlumniVerifications\Pages;

use App\Filament\Resources\AlumniVerifications\AlumniVerificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlumniVerification extends EditRecord
{
    protected static string $resource = AlumniVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
