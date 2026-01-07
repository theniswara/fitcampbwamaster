<?php

namespace App\Filament\Resources\GymTestimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GymTestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('occupation')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('photo')
                    ->required()
                    ->image(),

                Select::make('gym_id')
                    ->required()
                    ->relationship('gym', 'name')
                    ->searchable()
                    ->preload(),

                Textarea::make('message')
                ->required(),
            ]);
    }
}
