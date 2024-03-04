<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '10s';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {   
            //using filters to not show the data when the date is not selected or not in the range
        $startDate = $this->filters['Start Date'];
        $endDate = $this->filters['End Date'];

        return [
            Stat::make('Total Users', 
            User::when($startDate,
            fn($query) => $query->whereDate('created_at','>', $startDate)
            )
            ->when($endDate,
            fn($query)=>$query->whereDate('created_at','<', $endDate))
            ->count()
            )
            ->description('Users')
            ->descriptionIcon('heroicon-o-user-group')
            ->color('success') 
            ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Posts', Post::query()->count())
            ->descriptionIcon('heroicon-o-clipboard-document-list')
            ->description('Posts')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('primary'),

            Stat::make('Total Comments', Comment::query()->count())
            ->descriptionIcon('heroicon-o-chat-bubble-oval-left-ellipsis')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->description('Comments')
            ->color('warning'),

            Stat::make('Total Category', Category::query()->count())
            ->descriptionIcon('heroicon-o-clipboard-document')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->description('Categories')
            ->color('danger'),

            Stat::make('Total Admins', User::query()->where('role', 'admin')->count())
            ->descriptionIcon('heroicon-o-users')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->description('Admins')
            ->color('success'),

            Stat::make('Total Members', User::query()->where('role', 'member')->count())
            ->descriptionIcon('heroicon-o-users')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->description('Members')
            ->color('info'),
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'member';
    }
}