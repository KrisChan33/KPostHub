<?php
namespace App\Filament\Resources;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post; 
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Group;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\Section;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Filters\TernaryFilter;
use PhpParser\Node\Stmt\Label;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Tabs::make('Create a Post')->tabs([
                Tab::make('Create a Post')->icon('heroicon-o-pencil') ->schema([
                    TextInput::make('title')->unique(ignoreRecord:true)->required()->rules('min:8| max:50'),
                    TextInput::make('slug')->required()->rules('min:8| max:50'),
                    Select::make('category_id')->required()->label('Category')
                    ->relationship('category', 'name'), // this is the relationship between the category and the post/ also the name of the category
                    // ->options(Category::all()->pluck('name', 'id')),  => this can call the database and slow down the app, so we use the query builder below
                    ColorPicker::make('color')->required()->rgba(), 
                    ])->columnSpan(3)->columns(2),
                    
                Tab::make('Content')->icon('heroicon-o-newspaper')->schema([
                    MarkdownEditor::make('content')->columnspan('full')->required()->rules('min:8| max:50'),
                ]),
                Tab::make('Meta')->icon('heroicon-o-photo')->schema([
                    FileUpload::make('thumbnail')->disk('public')->directory('images')->required(),
                    TagsInput::make('tags')->required(),
                    Checkbox::make('published')->columnSpan(3)->columns(1),
                ]),
                
            ])->activeTab(1)->persistTabinQueryString(),
        ])->columns(1);
            }
                // ->schema([
                //     Section::make('Create a Post')->description('Create a Post Here')
                //     ->schema([
                //         TextInput::make('title')->unique(ignoreRecord:true)->required()->rules('min:8| max:50'),
                //         TextInput::make('slug')->required()->rules('min:8| max:50'),
                //         Select::make('category_id')->required()->label('Category')
                //         ->relationship('category', 'name'), // this is the relationship between the category and the post/ also the name of the category
                //         // ->options(Category::all()->pluck('name', 'id')),  => this can call the database and slow down the app, so we use the query builder below
                //         ColorPicker::make('color')->required()->rgba(), 
                //         MarkdownEditor::make('content')->columnspan('full')->required()->rules('min:8| max:50'),
                //         ])->columnSpan(3)->columns(2),
                //     Group::make()->schema([
                //         Section::make('image')->description('Post Details')
                //         ->collapsible()
                //         ->schema([
                //         FileUpload::make('thumbnail')->disk('public')->directory('/thumbnail')->required(),
                //         ]),
                //         Section::make('meta')->schema([
                //             TagsInput::make('tags')->required(),
                //             Checkbox::make('published'),
                //         ]),
                //     ])->columnSpan([
                //         'default'=>1,
                //         'md'=>4,
                //         'lg'=>3,
                //         'xl'=>1]),
                //     ])->columns([//using array to setup the columns responsive
                //         'default'=>1,
                //         'md'=>2,
                //         'lg'=>3,
                //         'xl'=>4]);
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->circular(),
                ColorColumn::make('color'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug'),
                TextColumn::make('category.name'),
                TextColumn::make('tags'),
                CheckboxColumn::make('published'),
                TextColumn::make('created_at')
                ->label('Published on')
                ->date('d M Y  H:i:s')
                ->sortable()
                ->searchable(),
                // TextColumn::make('updated_at')
                // ->label('Updated on')
                // ->date('Y M D H:i:s'),
                ])
            ->filters([
                Filter::make('Public Post')->query(
                    function (Builder $query):Builder{
                    return $query->where('published', true);
                    }
                ),
                Filter::make('Public Post')->query(
                    function (Builder $query):Builder{
                    return $query->where('published', false);
                    }
                ),
                // TernaryFilter::make('published'), = for yes or no /  bool
                SelectFilter::make('category_id')
                ->label('Category')
                ->relationship('category','name')
                // ->options(Category::all()->pluck('name','id'))
                // ->searchable()
                ->multiple()
                // ->multiple(), = optional
                ->preload(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}