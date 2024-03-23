<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\PostsChart;
use App\Filament\Widgets\Practicing;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    public ?User $record;
    protected function getHeaderWidgets():array
    {
        return [
        // PostsChart::class,
            Practicing::class,
    ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            // PostsChart::class,
        ];
    }
}