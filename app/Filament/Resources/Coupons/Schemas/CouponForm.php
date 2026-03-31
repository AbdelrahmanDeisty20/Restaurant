<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('Code'))
                    ->required()
                    ->unique('coupons', 'code', ignoreRecord: true)
                    ->maxLength(50),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'fixed' => __('Fixed Amount'),
                        'percentage' => __('Percentage'),
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('value')
                    ->label(__('Value'))
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('min_order_value')
                    ->label(__('Min Order Value'))
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                TextInput::make('max_discount')
                    ->label(__('Max Discount Amount'))
                    ->numeric()
                    ->helperText(__('Only for percentage type'))
                    ->minValue(0),
                DateTimePicker::make('start_date')
                    ->label(__('Start Date')),
                DateTimePicker::make('end_date')
                    ->label(__('End Date')),
                TextInput::make('usage_limit')
                    ->label(__('Total Usage Limit'))
                    ->numeric()
                    ->helperText(__('Leave empty for unlimited')),
                TextInput::make('user_usage_limit')
                    ->label(__('Per User Limit'))
                    ->numeric()
                    ->default(1)
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->required()
                    ->default(true),
            ]);
    }
}
