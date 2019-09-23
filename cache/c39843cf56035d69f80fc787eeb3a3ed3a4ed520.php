---
title: Defer Loading
extends: _layouts.documentation
section: content
---

Livewire offers a `wire:init` directive to run an action as soon as the component is rendered. This can be helpful in cases where you don't want to hold up the entire page load, but want to load some data immediately after the page load.

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'app/Http/Livewire/ShowPosts.php',
    'viewName' => 'resources/views/livewire/show-posts.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

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

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div wire:init="loadPosts">
    <ul>
        @foreach ($posts as $post)
            <li>{{ $post->title }}</li>
        @endforeach
    </ul>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

The `loadPosts` action will be run imediately after the Livewire component renders on the page.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/8f061297988781b3e9ef46eada4bf8fcfa651557.blade.md ENDPATH**/ ?>