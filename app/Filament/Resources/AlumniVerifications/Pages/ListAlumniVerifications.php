<?php

namespace App\Filament\Resources\AlumniVerifications\Pages;

use App\Filament\Resources\AlumniVerifications\AlumniVerificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumniVerifications extends ListRecords
{
    protected static string $resource = AlumniVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
