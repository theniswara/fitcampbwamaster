<?php

namespace App\Filament\Resources\Gyms\Schemas;

use App\Models\Facility;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class GymForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //

                Fieldset::make('Details')
                    ->columns(1)
                    ->schema([

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('address')
                            ->rows(3)
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->required(),

                        Repeater::make('gymPhotos')
                            ->relationship('gymPhotos')
                            ->schema([
                                FileUpload::make('photo')
                                ->required(),
                            ]),
                    ]),

                Fieldset::make('Additional')
                ->columns(1)
                ->schema([

                    Textarea::make('about')
                        ->required(),

                    Repeater::make('gymFacilities')
                        ->relationship('gymFacilities')
                        ->schema([
                            Select::make('facility_id')
                                ->label('Gym Facility')
                                ->relationship('facility', 'name')
                                ->preload()
                                ->searchable()
                                ->required(),
                        ]),

                    Select::make('is_popular')
                        ->options([
                            true => 'Popular',
                            false => 'Not Popular',
                        ])
                        ->required(),

                    Select::make('city_id')
                        ->relationship('city', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TimePicker::make('open_time_at')
                        ->required(),

                    TimePicker::make('closed_time_at')
                        ->required(),
                ]),
            ]);
    }
}
