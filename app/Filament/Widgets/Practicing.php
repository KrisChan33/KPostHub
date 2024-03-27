<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Practicing extends BaseWidget
{
    public ?User $record;

    public function __construct()
    {
        $this->record = auth()->user();
    }
    protected function getStats(): array
    {
        #$userName = auth()->user()->name;
        return [
            // Stat::make('Users',$this->record->email),
            // Stat::make('Users',$this->record->count()),
            // Stat::make('Number of Comments',$this->record->comments()->count()),
            // Stat::make('Number of Post',$this->record->posts()->count()),
            #   Stat::make('Post', $this->$userName->comments()::count())
        ];
    }
}
