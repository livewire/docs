---
title: Authorization
extends: _layouts.documentation
section: content
---

To authorize actions in Livewire, you can use the `AuthorizesRequests` trait in any component, then call `$this->authorize()` like you normally would inside a controller. For example:

@code(['lang' => 'php'])
@verbatim
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditPost extends \Livewire\Component
{
    use AuthorizesRequests;

    public $postId;

    public function mount(Post $postId)
    {
        $this->postId = $postId;
    }

    public function save()
    {
        $post = Post::find($this->postId);

        $this->authorize('update', $post);

        $post->update(['title' => $this->title]);
    }
}
@endverbatim
@endcode
