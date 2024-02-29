<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;


class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Post Management';
    public static function form(Form $form): Form

    {
        
        return $form
            ->schema([
                Select::make('user_id')->relationship('user','name')->required()->searchable()->preload(),
                TextInput::make('comment')->required(),
                MorphToSelect::make('commentable')->types([
                    MorphToSelect\Type::make(User::class)->titleAttribute('id'),
                    MorphToSelect\Type::make(Post::class)->titleAttribute('title'),
                    MorphToSelect\Type::make(Category::class)->titleAttribute('name'),
                    MorphToSelect\Type::make(Comment::class)->titleAttribute('comment'),
                ])->required()->searchable()->preload(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->sortable()->searchable(),
                TextColumn::make('commentable_id')->sortable()->searchable(),
                TextColumn::make('commentable_type')->sortable()->searchable(),
                TextColumn::make('comment')->sortable()->searchable(),
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
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
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