<?php

namespace App\Filament\Resources\AlumniVerifications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AlumniVerificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('alumni_name')
                    ->required(),
                TextInput::make('graduation_year')
                    ->required(),
                TextInput::make('student_id')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('risk_score')
                    ->numeric(),
                Textarea::make('ai_reasoning')
                    ->columnSpanFull(),
                TextInput::make('proof_id'),
            ]);
    }
}
