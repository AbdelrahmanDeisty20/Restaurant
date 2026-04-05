<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Orders Distribution by Status';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Order::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Convert keys to Title Case for better display
        $labels = array_map(fn($status) => ucfirst($status), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Status Count',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#fbbf24', // pending - amber
                        '#60a5fa', // processing - blue
                        '#10b981', // delivered - green
                        '#ef4444', // cancelled - red
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
