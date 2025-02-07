<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
