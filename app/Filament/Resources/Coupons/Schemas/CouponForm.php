<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Coupon Configuration'))
                    ->icon('heroicon-o-ticket')
                    ->description(__('Define the unique code and its discount value.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('code')
                            ->label(__('Code'))
                            ->required()
                            ->readOnly()
                            ->unique('coupons', 'code', ignoreRecord: true)
                            ->maxLength(50)
                            ->prefixIcon('heroicon-m-qr-code')
                            ->suffixAction(
                                Action::make('generateCode')
                                    ->label(__('Generate'))
                                    ->icon('heroicon-m-sparkles')
                                    ->action(function (Set $set) {
                                        $set('code', strtoupper(Str::random(8)));
                                    })
                            ),
                        TextInput::make('value')
                            ->label(__('Discount Percentage'))
                            ->required()
                            ->numeric()
                            ->prefix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->prefixIcon('heroicon-m-receipt-percent'),
                    ]),

                Section::make(__('Usage Constraints'))
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->description(__('Set logical limits on how and when the coupon is used.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('min_order_value')
                            ->label(__('Min Order Value'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('EGP')
                            ->prefixIcon('heroicon-m-shopping-cart'),
                        TextInput::make('max_discount')
                            ->label(__('Max Discount Amount'))
                            ->numeric()
                            ->helperText(__('Only for percentage type'))
                            ->minValue(0)
                            ->prefix('EGP')
                            ->prefixIcon('heroicon-m-banknotes'),
                        TextInput::make('usage_limit')
                            ->label(__('Total Usage Limit'))
                            ->numeric()
                            ->helperText(__('Leave empty for unlimited'))
                            ->prefixIcon('heroicon-m-user-group'),
                        TextInput::make('user_usage_limit')
                            ->label(__('Per User Limit'))
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->prefixIcon('heroicon-m-user'),
                    ]),

                Section::make(__('Validity Period'))
                    ->icon('heroicon-o-calendar-days')
                    ->description(__('Set the specific timeframe for the coupon activity.'))
                    ->columns(2)
                    ->components([
                        DateTimePicker::make('start_date')
                            ->label(__('Start Date'))
                            ->prefixIcon('heroicon-m-calendar-days'),
                        DateTimePicker::make('end_date')
                            ->label(__('End Date'))
                            ->prefixIcon('heroicon-m-calendar-days'),
                    ]),

                Section::make(__('Activation Status'))
                    ->icon('heroicon-o-power')
                    ->description(__('Enable or disable the coupon completely.'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required()
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}
