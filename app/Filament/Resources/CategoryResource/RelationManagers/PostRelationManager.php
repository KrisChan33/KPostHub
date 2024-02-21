<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostRelationManager extends RelationManager
{
    protected static string $relationship = 'post';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Create a Post')->description('Create a Post Here')
            ->schema([
                TextInput::make('title')->unique(ignoreRecord:true)->required()->rules('min:8| max:50'),
                TextInput::make('slug')->required()->rules('min:8| max:50'),
                // ->options(Category::all()->pluck('name', 'id')),  => this can call the database and slow down the app, so we use the query builder below
                ColorPicker::make('color')->required()->rgba(), 
                MarkdownEditor::make('content')->columnspan('full')->required()->rules('min:8| max:50'),
                ])->columnSpan(3)->columns(2),
            Group::make()->schema([
                Section::make('image')->description('Post Details')
                ->collapsible()
                ->schema([
                FileUpload::make('thumbnail')->disk('public')->directory('/thumbnail')->required(),
                ]),
                Section::make('meta')->schema([
                    TagsInput::make('tags')->required(),
                    Checkbox::make('published'),
                ]),
            ])->columnSpan([
                'default'=>1,
                'md'=>4,
                'lg'=>3,
                'xl'=>1]),
            ])->columns([//using array to setup the columns responsive
                'default'=>1,
                'md'=>2,
                'lg'=>3,
                'xl'=>4]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('tags'),
                Tables\Columns\CheckboxColumn::make('published'),
                Tables\Columns\TextColumn::make('created_at')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}   