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

    protected function getStats(): array
    {
        return [
            Stat::make(__('New Users (Last 30 Days)'), User::where('created_at', '>=', now()->subDays(30))->count())
                ->description(__('Total users registered recently'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->url(UserResource::getUrl('index')),

            Stat::make(__('Pending Orders'), Order::where('status', 'pending')->count())
                ->description(__('Orders awaiting preparation'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->chart([5, 8, 3, 12, 7, 10, 15])
                ->url(OrderResource::getUrl('index', ['tableFilters[status][value]' => 'pending'])),

            Stat::make(__('Total Revenue'), Number::currency(Order::where('status', 'delivered')->sum('total_price') ?? 0, 'EGP'))
                ->description(__('Revenue from delivered orders'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([1000, 1500, 1200, 2000, 1800, 2500, 3000])
                ->url(OrderResource::getUrl('index')),

            Stat::make(__('Active Products'), Product::where('is_active', true)->count())
                ->description(__('Current products in stock'))
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning')
                ->url(ProductResource::getUrl('index')),

        ];
    }
}
