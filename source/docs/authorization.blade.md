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

    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function save()
    {
        $this->authorize('update', $this->post);

        $this->post->update(['title' => $this->title]);
    }
}
@endverbatim
@endcode
