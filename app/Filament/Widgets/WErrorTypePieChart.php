<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Widgets\PieChartWidget;
use Illuminate\Support\Facades\DB;

class WErrorTypePieChart extends PieChartWidget
{
    protected static ?string $heading = 'Distribució de tipus d\'errors';

    protected function getData(): array
    {
        $types = Event::select('title', DB::raw('count(*) as count'))
            ->where('type', 'error')
            ->groupBy('title')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $types->pluck('count'),
                ],
            ],
            'labels' => $types->pluck('title')->toArray(),
        ];
    }
}
