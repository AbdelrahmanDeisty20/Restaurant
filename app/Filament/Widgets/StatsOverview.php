<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\Coupons\CouponResource;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            // Row 1
            Stat::make(__('Total Products'), \App\Models\Product::count())
                ->description(__('Total units in store'))
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary')
                ->url(ProductResource::getUrl('index')),

            Stat::make(__('Total Users'), \App\Models\User::count())
                ->description(__('Total registered users'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->url(UserResource::getUrl('index')),

            Stat::make(__('Total Reviews'), \App\Models\OrderReview::count())
                ->description(__('Total customer feedback'))
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
                ->color('success')
                ->url(UserResource::getUrl('index')), // Assuming reviews are related to users or separate resource

            // Row 2
            Stat::make(__('Bad Reviews'), \App\Models\OrderReview::where('rating', '<', 3)->count())
                ->description(__('Reviews less than 3 stars'))
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make(__('Pending Orders'), \App\Models\Order::where('status', 'pending')->count())
                ->description(__('Orders awaiting preparation'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(OrderResource::getUrl('index', ['tableFilters[status][value]' => 'pending'])),

            Stat::make(__('Total Revenue'), Number::currency(\App\Models\Order::where('status', 'delivered')->sum('total_price') ?? 0, 'EGP'))
                ->description(__('Revenue from delivered orders'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([1000, 1500, 1200, 2000, 1800, 2500, 3000])
                ->url(OrderResource::getUrl('index')),

            // Row 3
            Stat::make(__('Active Coupons'), \App\Models\Coupon::where('is_active', true)->count())
                ->description(__('Validated discount codes'))
                ->descriptionIcon('heroicon-m-ticket')
                ->color('success')
                ->url(CouponResource::getUrl('index')),

            Stat::make(__('Total Coupon Usage'), \App\Models\Coupon::sum('used_count'))
                ->description(__('Times coupons were applied'))
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make(__('Active Offers'), \App\Models\Offer::where('is_active', true)->count())
                ->description(__('Active discounts on products'))
                ->descriptionIcon('heroicon-m-gift')
                ->color('primary')
                ->url(\App\Filament\Resources\Offers\OfferResource::getUrl('index')),
        ];
    }

}
