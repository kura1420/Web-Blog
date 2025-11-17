<?php

namespace App\Traits;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait PostTrait
{
    //
    protected function statusText(): Attribute
    {
        return Attribute::get(
            fn(mixed $value, array $attr) => PostStatusEnum::from($attr['status'])->label()
        );
    }

    protected function publishedAtFormatted(): Attribute
    {
        return Attribute::get(
            fn(mixed $value, array $attr) => $attr['published_at']
                ? $attr['published_at']->format('F j, Y, g:i a')
                : null
        );
    }
}
