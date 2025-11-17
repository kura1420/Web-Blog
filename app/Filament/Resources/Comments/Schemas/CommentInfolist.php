<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('id')
                //     ->label('ID'),

                TextEntry::make('name'),

                TextEntry::make('email')
                    ->label('Email address'),

                TextEntry::make('post.title')
                    ->label('Pos'),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('message')
                    ->columnSpanFull(),
            ]);
    }
}
