<?php

namespace App\Enums;

enum PostStatusEnum: int
{
    //
    case DRAFT = 0;
    case PUBLISHED = 1;
    case ARCHIVED = 2;

    public function label(): string
    {
        return match ($this) {
            PostStatusEnum::DRAFT => 'Draft',
            PostStatusEnum::PUBLISHED => 'Published',
            PostStatusEnum::ARCHIVED => 'Archived',
        };
    }

    public static function options(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::PUBLISHED->value => self::PUBLISHED->label(),
            self::ARCHIVED->value => self::ARCHIVED->label(),
        ];
    }
}
