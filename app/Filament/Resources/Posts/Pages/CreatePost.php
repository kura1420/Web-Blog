<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Tag;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $tags = $data['tags'] ?? [];

        unset($data['tags']);

        $row = static::getModel()::create($data);

        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);

                $row->tags()->create([
                    'tag_id' => $tag->id,
                ]);
            }
        }

        return $row;
    }
}
