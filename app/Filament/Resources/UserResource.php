<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create a User Here')->description('')
                ->schema([
                    TextInput::make('name')->required()->rules('max:50')->required(),
                    TextInput::make('email')->email()->required()->suffix('@-gmail.com')->unique(ignoreRecord:true),
                    Select::make('role')->required()->options([
                        'Admin' => 'Admin',
                        'Member' => 'Member',]),
                    TextInput::make('password')->autocomplete(true)->password()->required(),
                ])->columnspanfull()->columns([
                    'default' => 2,
                    'md' => 2,  
                    'lg' => 2,
                ]),
                    ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('password'),
                TextColumn::make('created_at')->date('d M Y')->sortable(),
                TextColumn::make('updated_at')->date('d M Y')->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
