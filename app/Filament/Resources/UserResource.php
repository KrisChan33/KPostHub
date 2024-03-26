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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Filterz;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class UserResource extends Resource
{
    protected static ?int $navigationSort = 4;
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create a User Here')->description('')
                    ->schema([
                        TextInput::make('name')->required()->rules('max:50')->required(),
                        TextInput::make('email')->email()->required()->suffix('@-gmail.com')->unique(ignoreRecord: true),
                        Select::make('role')
                            ->required()
                            ->Relationship('role', 'role'),
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
                TextColumn::make('role.role')
                    ->label('Role')
                    ->searchable()
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'admin' => 'success',
                            'member' => 'warning',
                            'user' => 'danger',
                        };
                    }),
                // ->color(function(string $state):string {
                //     if ($state === 'admin') {
                //         return 'success';
                //     }
                //     elseif ($state === 'member') {
                //         return 'warning';
                //     }
                //     else {
                //         return 'danger';
                //     }
                // }),
                TextColumn::make('password'),
                TextColumn::make('created_at')->date('d M Y')->sortable(),
                TextColumn::make('updated_at')->date('d M Y')->sortable(),
            ])
            ->filters([
                Filter::make('admin')
                    ->query(fn (Builder $query): Builder => $query->where('role', 'admin')),

                Filter::make('member')
                    ->query(fn (Builder $query): Builder => $query->where('role', 'member')),

                Filter::make('user')
                    ->query(fn (Builder $query): Builder => $query->where('role', 'user'))
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

    public static function canAccess(): bool
    {
        return Auth::user()->role->role === 'admin';
    }

    public static function query()
    {
        return parent::query()->where('id', Auth::id());
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
