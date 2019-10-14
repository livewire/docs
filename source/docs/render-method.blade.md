---
title: The <code>render()</code> method
extends: _layouts.documentation
section: content
---

A Livewire component class needs only one method to function properly: `render()`. This method fires on every component update and is in charge of returning the Blade view to be rendered.

@tip
In simple components, you don't need to define a `render` method yourself. The base Livewire component class has a dynamic `render` method included.
@endtip

### Returning Blade {#returning-blade}
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

@warning
Make sure your Blade views have only ONE root HTML element.
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

@warning
Although `render()` methods closely resemble controller methods, there are a few techniques you are used to using in controllers that aren't available in Livewire components.

Here are two common things you might forget ARE NOT possible in Livewire:
@endwarning

@code(['lang' => 'php'])
@verbatim
public function render()
{
    return back();
    // Or
    return ['some' => 'data'];
}
@endverbatim
@endcode
