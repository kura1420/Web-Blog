<?php

namespace App\Services;

use App\Enums\PostStatusEnum;

class PostService
{
    public static function setPublishedAt(object $row)
    {
        return $row->status === PostStatusEnum::PUBLISHED->value && is_null($row->published_at)
            ? now()
            : $row->published_at;
    }
}
