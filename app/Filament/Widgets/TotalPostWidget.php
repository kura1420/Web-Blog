<?php

namespace App\Filament\Widgets;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalPostWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $postDraft = Post::where('status', PostStatusEnum::DRAFT->value)->count();
        $postPublish = Post::where('status', PostStatusEnum::PUBLISHED->value)->count();
        $postArchived = Post::where('status', PostStatusEnum::ARCHIVED->value)->count();

        return [
            //
            Stat::make('Draft Post', $postDraft),
            Stat::make('Total Post', $postPublish),
            Stat::make('Archived Post', $postArchived),
        ];
    }
}
