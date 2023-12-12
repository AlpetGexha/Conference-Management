<?php

namespace App\Filament\Resources\AttendeeResource\Widgets;

use App\Filament\Resources\AttendeeResource\Pages\ListAttendees;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class AttendeeStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListAttendees::class;
    }

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Attendees Count', $this->getPageTableQuery()->count())
                ->description('Total number of attendees')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                ->chart([1, 2, 3, 4, 5, 4, 1, 1]),
            Stat::make('Total Revenue', Number::abbreviate(
                $this->getPageTableQuery()->sum('ticket_cost'), precision: 2)
            ),
        ];
    }
}
