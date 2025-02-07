<?php

namespace App\Observers;

use App\Models\Post;
use Str;

class PostObserver
{
    public function creating(Post $post): void
    {
        $post->uuid = Str::uuid();
    }
}
