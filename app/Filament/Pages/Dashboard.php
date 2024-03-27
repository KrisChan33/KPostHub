<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Facades\Date;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected ?string $heading = 'Welcome to "K-Internship-Daily-Accomplishment-Report-Sys"';
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('Dates Search')->schema([
                // TextInput::make('search')
                //     ->placeholder('Search...')
                //     ->label('Search'),
                DatePicker::make('Start Date')
                    ->label('Start Date')
                    ->placeholder('Select a date')
                    ->default(Date::now()->format('Y-m-d')),
                DatePicker::make('End Date')
                    ->label('End Date')
                    ->placeholder('Select a date range')
                    ->default(Date::now()->format('Y-m-d'))
            ])->columns(2)
        ]);
    }
}
