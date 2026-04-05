<?php

namespace App\Filament\Resources\Drivers;

use App\Filament\Resources\Drivers\Pages\ManageDrivers;
use App\Models\Driver;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getLabel(): string
    {
        return __('Driver');
    }

    public static function getPluralLabel(): string
    {
        return __('Drivers');
    }

    public static function getNavigationLabel(): string
    {
        return __('Drivers');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label(__('User Account')),
                TextInput::make('name')
                    ->required()
                    ->label(__('Driver Name')),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->label(__('Phone Number')),
                \Filament\Forms\Components\FileUpload::make('avatar')
                    ->directory('drivers/avatars')
                    ->image()
                    ->label(__('Avatar')),
                TextInput::make('rating')
                    ->numeric()
                    ->disabled()
                    ->placeholder('Calculated from reviews')
                    ->label(__('Rating')),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable'
                    ])
                    ->default('available')
                    ->required()
                    ->label(__('Status')),
                TextInput::make('current_lat')
                    ->numeric()
                    ->disabled()
                    ->label(__('Current Latitude')),
                TextInput::make('current_lng')
                    ->numeric()
                    ->disabled()
                    ->label(__('Current Longitude')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->label(__('Avatar')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Name')),
                TextColumn::make('user.email')
                    ->label(__('Linked Email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->label(__('Phone')),
                TextColumn::make('rating')
                    ->numeric(1)
                    ->sortable()
                    ->label(__('Rating')),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        default => 'gray',
                    })
                    ->label(__('Status')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDrivers::route('/'),
        ];
    }
}
