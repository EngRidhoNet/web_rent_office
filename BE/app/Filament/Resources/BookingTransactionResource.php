<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\BookingTransaction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Booking Management';
    protected static ?string $navigationLabel = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('booking_trx_id')
                    ->label('Transaction ID')
                    ->required()
                    ->maxLength(255)
                    ->readonly()
                    ->helperText('Automatically generated')
                    ->default(function () {
                        do {
                            $code = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
                        } while (BookingTransaction::where('booking_trx_id', $code)->exists());

                        return $code;
                    }),

                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->rules(['min:0']),

                TextInput::make('duration')
                    ->label('Booking Duration')
                    ->required()
                    ->numeric()
                    ->suffix('Days')
                    ->minValue(1),

                DatePicker::make('started_at')
                    ->label('Start Date')
                    ->required()
                    ->native(false),

                DatePicker::make('ended_at')
                    ->label('End Date')
                    ->required()
                    ->native(false)
                    ->after('started_at'),

                Select::make('is_paid')
                    ->label('Payment Status')
                    ->options([
                        '1' => 'Paid',
                        '0' => 'Unpaid',
                    ])
                    ->required()
                    ->visibleOn('create'),

                Select::make('office_space_id')
                    ->relationship('officeSpace', 'name')
                    ->label('Office Space')
                    ->searchable()
                    ->preload()
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_trx_id')
                    ->label('Transaction ID')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->toggleable(),

                TextColumn::make('officeSpace.name')
                    ->label('Office Space')
                    ->searchable(),

                BadgeColumn::make('is_paid')
                    ->label('Payment Status')
                    ->colors([
                        'success' => '1',
                        'danger' => '0',
                    ])
                    ->formatStateUsing(fn($state) => $state ? 'Paid' : 'Unpaid'),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->suffix(' Days')
                    ->sortable(),

                TextColumn::make('started_at')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('ended_at')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_paid')
                    ->label('Payment Status')
                    ->options([
                        '1' => 'Paid',
                        '0' => 'Unpaid',
                    ]),
                SelectFilter::make('office_space')
                    ->relationship('officeSpace', 'name')
                    ->label('Office Space'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // You can add relation managers here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
            // 'view' => Pages\ViewBookingTransaction::route('/{record}'),
        ];
    }
}
