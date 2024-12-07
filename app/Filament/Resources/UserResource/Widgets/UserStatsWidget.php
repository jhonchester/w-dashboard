<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Overall Count', User::count())
                ->description('Users that have joined')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([1,3,5,10,20,40,50,75,100,120,150,180,200,300,400,500])
                ->color('success'),
            Stat::make('Total Admin', User::where('role', 'admin')->count())
                ->description('Registered Admin')
                ->descriptionIcon('heroicon-m-user', IconPosition::Before)
                ->color('success'),
            Stat::make('Total User', User::where('role', 'user')->count())
                ->description('Users Count')
                ->descriptionIcon('heroicon-m-users', IconPosition::Before)
                ->color('success'),
        ];
    }
}
