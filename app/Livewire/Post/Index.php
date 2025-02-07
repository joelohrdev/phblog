<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    #[On('render')]
    public function render(): View
    {
        return view('livewire.post.index', [
            'posts' => Post::latest()->paginate(10)
        ]);
    }
}
