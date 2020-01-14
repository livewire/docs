---
title: Computed Properties
extends: _layouts.documentation
section: content
---

Livewire offers an api for accessing dynamic properties. This is especially helpful for deriving properties from the database or another persistent store like a cache.

@code(['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    // Computed Property
    public function getFooProperty()
    {
        return 'foo';
    }
@endverbatim
@endcode

Now, you can access `$this->foo` from either the component's class or Blade view:

@codeComponent([
    'className' => 'ShowPost.php',
    'viewName' => 'show-post.blade.php',
])
@slot('class')
use Livewire\Component;

class ShowPost extends Component
{
    public $postId;

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function deletePost()
    {
        $this->post->delete();
    }

    public function render()
    {
        return view('livewire.show-post');
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $this->post->title }}</h1>
    ...
    <button wire:click="deletePost">Delete Post</button>
</div>
@endverbatim
@endslot
@endcodeComponent

@tip
Computed properties are cached for an individual Livewire request lifecycle. Meaning, if you call `$this->post` 5 times in a component's blade view, it won't make a seperate database query every time.
@endtip
