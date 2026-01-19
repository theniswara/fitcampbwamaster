<?php

namespace App\Filament\Resources\SubscribeTransactions\Tables;

use App\Models\SubscribeTransaction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SubscribeTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('subscribePackage.icon'),

                TextColumn::make('name'),

                TextColumn::make('booking_trx_id'),

                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi'),

            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('subscribe_package_id')
                    ->label('Subscribe Package')
                ->relationship('subscribePackage', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('approve')
                    ->label('Approve')
                    ->action(function (SubscribeTransaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        // Trigger the custom notificaton
                        Notification::make()
                            ->title('Transaction Approved')
                            ->success()
                            ->body('The transaction has been succesfully approved.')
                            ->send();
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(SubscribeTransaction $record) => !$record->is_paid),


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
