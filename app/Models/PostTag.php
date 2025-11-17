<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    //
    use HasFactory, HasUlids;

    protected $guarded = [];

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
