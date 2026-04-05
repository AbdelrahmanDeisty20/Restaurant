<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Governorate;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersByGovernorateChart extends ChartWidget
{
    protected ?string $heading = 'Orders Distribution by Governorate';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Order::query()
            ->join('governorates', 'orders.governorate_id', '=', 'governorates.id')
            ->select('governorates.name_en', DB::raw('count(*) as count'))
            ->groupBy('governorates.name_en')
            ->pluck('count', 'name_en')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => array_values($data),
                    'backgroundColor' => '#6366f1',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
