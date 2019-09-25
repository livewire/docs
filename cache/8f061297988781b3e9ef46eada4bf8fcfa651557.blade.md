---
title: Defer Loading
extends: _layouts.documentation
section: content
---

Livewire offers a `wire:init` directive to run an action as soon as the component is rendered. This can be helpful in cases where you don't want to hold up the entire page load, but want to load some data immediately after the page load.

@codeComponent([
    'className' => 'app/Http/Livewire/ShowPosts.php',
    'viewName' => 'resources/views/livewire/show-posts.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ShowPosts extends Component
{
    protected $posts = [];

    public function loadPosts()
    {
        $this->posts = Post::all();
    }

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => $this->posts,
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div wire:init="loadPosts">
    <ul>
        @foreach ($posts as $post)
            <li>{{ $post->title }}</li>
        @endforeach
    </ul>
</div>
@endverbatim
@endslot
@endcodeComponent

The `loadPosts` action will be run imediately after the Livewire component renders on the page.
