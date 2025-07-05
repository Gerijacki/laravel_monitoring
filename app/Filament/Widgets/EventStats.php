<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventStats extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();

        // Projectes que més errors han tingut (top 5)
        $topProjectsWithErrors = Event::select('project_id', DB::raw('count(*) as errors_count'))
            ->where('type', 'error')
            ->groupBy('project_id')
            ->orderByDesc('errors_count')
            ->limit(5)
            ->with('project')
            ->get();

        // Tipus d'errors amb el seu recompte
        $errorTypes = Event::select('title', DB::raw('count(*) as count'))
            ->where('type', 'error')
            ->groupBy('title')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return [
            Stat::make('Errors avui', Event::where('type', 'error')->whereDate('occurred_at', $today)->count())
                ->description('Total d’errors registrats avui')
                ->color('danger'),

            Stat::make('Total events avui', Event::whereDate('occurred_at', $today)->count())
                ->description('Tots els tipus d’events avui')
                ->color('primary'),

            Stat::make('Projectes actius avui', Project::whereHas('events', function ($query) use ($today) {
                $query->whereDate('occurred_at', $today);
            })->count())
                ->description('Projectes que han enviat events avui')
                ->color('success'),

            Stat::make(
                'Projectes amb més errors',
                $topProjectsWithErrors->sum('errors_count')
            )
                ->description(implode(', ', $topProjectsWithErrors->map(fn($p) => $p->project?->name . " ({$p->errors_count})")->toArray()))
                ->color('warning'),

            Stat::make('Errors més comuns', '')
                ->description(implode(', ', $errorTypes->map(fn($e) => "{$e->title} ({$e->count})")->toArray()))
                ->color('danger'),
        ];
    }
}
