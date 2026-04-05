<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyOrdersChart extends ChartWidget
{
    public function getHeading(): ?string
    {
        return __('Monthly Orders Trend');
    }

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = Order::query()
            ->select(DB::raw('count(*) as count'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')) 
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('Orders'),
                    'data' => array_values($data),
                    'fill' => 'start',
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
