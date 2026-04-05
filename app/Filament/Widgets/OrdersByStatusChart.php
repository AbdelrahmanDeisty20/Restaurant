<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersByStatusChart extends ChartWidget
{
    public function getHeading(): ?string
    {
        return __('Orders Distribution by Status');
    }

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Order::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Translate status keys
        $labels = array_map(fn($status) => __($status), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => __('Status Count'),
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#fbbf24', // pending - amber
                        '#60a5fa', // processing - blue
                        '#10b981', // delivered - green
                        '#ef4444', // cancelled - red
                        '#8b5cf6', // preparing - violet
                        '#3b82f6', // on_the_way - blue
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
