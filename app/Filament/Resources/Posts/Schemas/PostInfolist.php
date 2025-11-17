<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('title')
                    ->size('xl')
                    ->weight('bold')
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'text-2xl font-bold mb-4']),

                TextEntry::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->badge()
                    ->color('gray')
                    ->columnSpanFull(),

                TextEntry::make('content')
                    ->label('Content Preview')
                    ->html()
                    ->limit(300)
                    ->columnSpan(2)
                    ->helperText('First 300 characters of the post content'),

                ImageEntry::make('cover')
                    ->label('Cover')
                    ->disk('public')
                    ->columnSpan(1),

                TextEntry::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-tag'),

                TextEntry::make('status')
                    ->label('Status')
                    ->state(fn($record) => $record->statusText)
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Published' => 'success',
                        'Draft' => 'warning',
                        'Archived' => 'danger',
                        default => 'gray',
                    }),

                TextEntry::make('author.name')
                    ->label('Author')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-user'),

                TextEntry::make('published_at')
                    ->label('Published Date')
                    ->dateTime('M j, Y \a\t g:i A')
                    ->placeholder('Not published yet')
                    ->icon('heroicon-o-calendar')
                    ->color('success'),

                TextEntry::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y \a\t g:i A')
                    ->icon('heroicon-o-plus-circle')
                    ->color('gray'),

                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y \a\t g:i A')
                    ->icon('heroicon-o-pencil')
                    ->color('gray'),

                TextEntry::make('tags.tag.name')
                    ->label('Tags')
                    ->badge()
                    ->separator(',')
                    ->color('primary')
                    ->placeholder('No tags assigned')
                    ->columnSpanFull()
                    ->icon('heroicon-o-hashtag'),
            ]);
    }
}
