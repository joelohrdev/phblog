<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    protected $fillable = [
        'uuid',
        'images',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'images' => 'array',
        ];
    }
}
