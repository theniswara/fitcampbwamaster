<?php

namespace App\Filament\Resources\SubscribeTransactions\Schemas;

use App\Models\SubscribePackage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

use function Laravel\Prompts\alert;

class SubscribeTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Wizard::make([
                    Step::make('Product and Price')
                    ->schema([

                        Grid::make(2)
                        ->schema([
                            Select::make('subscribe_package_id')
                                ->relationship('subscribePackage', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {

                                    $subscribePackage = SubscribePackage::find($state);
                                    $price = $subscribePackage ? $subscribePackage->price : 0;
                                    $duration = $subscribePackage ? $subscribePackage->duration : 0;

                                    $set('price', $price);
                                    $set('duration', $duration);

                                    $tax = 0.11;
                                    $totalTaxAmount = $tax * $price;

                                    $totalAmount = $price + $totalTaxAmount;
                                    $set('total_amount', number_format($totalAmount, 0, '', ''));
                                    $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                                })
                                ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                    $subscribePackageId = $state;
                                    if ($subscribePackageId) {
                                        $subscribePackageId = SubscribePackage::find($subscribePackageId);
                                        $price = $subscribePackageId ? $subscribePackageId->price : 0;
                                        $set('price', $price);

                                        $tax = 0.11;
                                        $totalTaxAmount = $tax * $price;
                                        $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                                    }
                                }),

                            TextInput::make('price')
                                ->required()
                                ->readOnly()
                                ->numeric()
                                ->prefix('IDR'),

                            TextInput::make('total_amount')
                                ->required()
                                ->readOnly()
                                ->numeric()
                                ->prefix('IDR'),

                            TextInput::make('total_tax_amount')
                                ->required()
                                ->readOnly()
                                ->numeric()
                                ->prefix('IDR'),

                            DatePicker::make('started_at')
                                ->required(),

                            DatePicker::make('ended_at')
                                ->required(),

                            TextInput::make('duration')
                                ->required()
                                ->readOnly()
                                ->numeric()
                                ->prefix('Days'),
                        ]),
                    ]),

                    Step::make('Customer Information')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('phone')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->maxLength(255),
                        ]),

                    ]),

                    Step::make('Payment Information')
                    ->schema([

                        TextInput::make('booking_trx_id')
                            ->required()
                            ->maxLength(255),

                        ToggleButtons::make('is_paid')
                            ->label('Apakah sudah membayar?')
                            ->boolean()
                            ->grouped()
                            ->icons([
                                true => 'heroicon-o-pencil',
                                false => 'heroicon-o-clock',
                            ])
                            ->required(),

                        FileUpload::make('proof')
                            ->image()
                            ->required(),
                    ]),
                ])
                ->columnSpan('full') // use full width for the Wizard
                ->columns(1) // make sure the form has a single column layout
                ->skippable(),
            ]);
    }
}
