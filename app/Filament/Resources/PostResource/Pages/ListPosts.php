<?php

namespace App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [ 
            'All'=> Tab::make(),
            'Publish'=> Tab::make()->modifyQueryUsing(function( EloquentBuilder $query){
                $query->where('published', true);
            }),
            'Un Publish'=> Tab::make()->modifyQueryUsing(function( EloquentBuilder $query){
                $query->where('published', false);
            }),
        ];

    }
}