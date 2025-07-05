<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\EventStats;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [
            EventStats::class,
        ];
    }
}
