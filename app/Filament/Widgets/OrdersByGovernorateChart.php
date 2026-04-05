<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Governorate;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersByGovernorateChart extends ChartWidget
{
    public function getHeading(): ?string
    {
        return __('Orders Distribution by Governorate');
    }

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Order::query()
            ->join('governorates', 'orders.governorate_id', '=', 'governorates.id')
            ->select('governorates.name_ar as name', DB::raw('count(*) as count'))
            ->groupBy('governorates.name_ar')
            ->pluck('count', 'name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('Orders'),
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
