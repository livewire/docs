---
title: The <code>render()</code> method
extends: _layouts.documentation
section: content
---

A Livewire component's `render` method gets called on the initial page load AND every subsequent component update.

@tip
In simple components, you don't need to define a `render` method yourself. The base Livewire component class has a dynamic `render` method included.
@endtip

## Returning Blade Views {#returning-blade}
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

@warning
Make sure your Blade view only has ONE root element.
@endwarning

@codeComponent([
    'className' => 'ShowPosts.php',
    'viewName' => 'show-posts.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all(),
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    @foreach ($posts as $post)
        @include('includes.post', $post)
    @endforeach
</div>
@endverbatim
@endslot
@endcodeComponent

## Returning Blade Template Strings {#returning-strings}
If your Livewire project uses Laravel 7 or above, you can optionally return a Blade template string from `->render()`.

@codeComponent(['className' => 'DeletePost.php'])
@slot('class')
@verbatim
use Livewire\Component;

class DeletePost extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function delete()
    {
        $this->post->delete();
    }

    public function render()
    {
        return <<<'blade'
            <div>
                <button wire:click="delete">Delete Post</button>
            </div>
        blade;
    }
}
@endverbatim
@endslot
@endcodeComponent

@tip
For inline components like above, you should use the <code>--inline</code> flag during creation: <code>artisan make:livewire delete-post --inline</code>
@endtip
