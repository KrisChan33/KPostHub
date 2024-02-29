<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '10s';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())
            ->description('Total Users')
            ->descriptionIcon('heroicon-o-user-group')
            ->color('success') 
            ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Posts', Post::query()->count())
            ->description('Total Posts')
            ->color('primary'),

            Stat::make('Category', Category::query()->count())
            ->descriptionIcon('heroicon-o-clipboard-document')
            ->description('Total Categories')
            ->color('warning'),
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()->role === 'admin';
    }
}