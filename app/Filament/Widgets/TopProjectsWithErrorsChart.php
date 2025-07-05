<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class TopProjectsWithErrorsChart extends BarChartWidget
{
    protected static ?string $heading = 'Projectes amb més errors';

    protected function getData(): array
    {
        $projects = Event::select('project_id', DB::raw('count(*) as count'))
            ->where('type', 'error')
            ->groupBy('project_id')
            ->orderByDesc('count')
            ->with('project')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Errors',
                    'data' => $projects->pluck('count'),
                ],
            ],
            'labels' => $projects->map(fn ($e) => $e->project?->name ?? 'Desconegut')->toArray(),
        ];
    }
}
