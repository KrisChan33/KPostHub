<?php
namespace App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'category';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Input Name')
                ->description('Input Category Name')
                ->schema([
                    TextInput::make('name')->required()->rule('max:50'),
                ])->columnSpan(1),
                Section::make('Input Slug')
                ->description('Input Category Slug')
                ->schema([
                    TextInput::make('slug')->required()->unique(ignoreRecord:true),
                ])->columnSpan(1),
                ])->columns(2);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('category')
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}