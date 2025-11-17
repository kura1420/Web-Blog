<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatusEnum;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        // 
                        Select::make('category_id')
                            ->label('Category')
                            ->searchable()
                            ->options(Category::orderBy('name')->pluck('name', 'id'))
                            ->required()
                            ->live()
                            ->columnSpan(5),

                        TextInput::make('title')
                            ->required()
                            ->columnSpan(5),

                        Select::make('status')
                            ->required()
                            ->options(PostStatusEnum::options())
                            ->default(0)
                            ->columnSpan(2),
                    ])->columnSpanFull(),

                FileUpload::make('cover')
                    ->required()
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory('posts')
                    ->image()
                    ->previewable(true)
                    ->columnSpanFull(),

                TagsInput::make('tags')
                    ->label('Tags')
                    ->placeholder('Add tags')
                    // ->suggestions(Tag::limit(10)->pluck('name'))
                    ->trim()
                    ->afterStateHydrated(function (TagsInput $component, $state, $record) {
                        if ($record) {
                            $component->state(
                                $record->tags->pluck('tag.name')
                            );
                        }
                    })
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->required()
                    ->extraAttributes([
                        'style' => 'min-height: 300px; height: 300px;',
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
