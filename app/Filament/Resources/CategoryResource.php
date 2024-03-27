<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Forms\Components\Group;
use App\Filament\Resources\CategoryResource\RelationManagers\PostRelationManager;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Category';
    protected static ?string $navigationGroup = 'Record Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Name')
                    ->description('Input Category Name')
                    ->schema([
                        TextInput::make('name')->required()->rule('max:50')
                            ->live(onBlur: true)
                            // ->live(debounce:500)
                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) { //can also user $Forms\Get $get, Category $category this are parameters we can used
                                $set('slug', Str::slug($state));
                            }),
                    ])->columnSpan(1),
                Section::make('Category Slug')
                    ->description('Input Category Slug')
                    ->schema([
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    ])->columnSpan(1),
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\PostRelationManager::class
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 0 ? 'success' : 'danger';
    }
}
