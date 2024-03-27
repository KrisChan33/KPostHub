<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostandCategory extends BaseWidget
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

            //Posts Stats
            Stat::make(
                'Total Posts',
                Post::when(
                    $startDate,
                    fn ($query) => $query->whereDate('created_at', '>=', $startDate)
                )
                    ->when(
                        $endDate,
                        fn ($query) => $query->whereDate('created_at', '<=', $endDate)
                    )->count()
            )
                ->description('Posts')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //Category Stats
            Stat::make(
                'Total Categories',
                Category::when(
                    $startDate,
                    fn ($query) => $query->whereDate('created_at', '>=', $startDate)
                )
                    ->when(
                        $endDate,
                        fn ($query) => $query->whereDate('created_at', '<=', $endDate)
                    )->count()
            )

                ->description('Categories')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()->role->role === 'admin' ||  auth()->user()->role->role === 'member';
    }
    public static function canAccess(): bool
    {
        return auth()->user()->role->role === 'admin' ||  auth()->user()->role->role === 'member';
    }
}
