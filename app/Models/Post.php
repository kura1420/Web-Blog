<?php

namespace App\Models;

use App\Services\PostService;
use App\Traits\PostTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasUlids;
    use PostTrait;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($row) {
            $row->user_id_author = auth()->id();
            $row->slug = str()->slug($row->title . ' ' . str()->random(5));

            $row->published_at = PostService::setPublishedAt($row);
        });

        static::updating(function ($row) {
            $row->published_at = PostService::setPublishedAt($row);
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id_author');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->hasMany(PostTag::class, 'post_id')
            ->with('tag');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
