<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Tag;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $tags = $data['tags'] ?? [];

        unset($data['tags']);

        $record->update($data);

        if (count($tags) > 0) {
            $tags_id = [];

            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);

                $tags_id[] = $tag->id;
            }

            $record->tags()->whereNotIn('tag_id', $tags_id)->delete();

            foreach ($tags_id as $tag_id) {
                $record->tags()->firstOrCreate(['tag_id' => $tag_id]);
            }
        }

        return $record;
    }
}
