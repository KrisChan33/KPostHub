<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Category Chart';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $data = Trend::model(Category::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfmonth(),
        )
        ->perDay()
        ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Category Chart',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}