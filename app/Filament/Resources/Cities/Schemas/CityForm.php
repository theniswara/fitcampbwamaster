<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Text field for city name (required, max 255 chars)
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // File upload for city photo (image only, required)
                FileUpload::make('photo')
                    ->image()
                    ->required(),
            ]);
    }
}
