<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create'),

                Select::make('roles')
                    ->label(__('Role Name'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->placeholder(__('Superuser')),
            ]);
    }
}
