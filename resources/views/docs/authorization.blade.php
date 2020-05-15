
To authorize actions in Livewire, you can use the `AuthorizesRequests` trait in any component, then call `$this->authorize()` like you normally would inside a controller. For example:

@component('components.code', ['lang' => 'php'])
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
@endcomponent
If you use a different guard to authenticate your users then also add an entry to middleware_group in the livewire config file:
@component('components.code', ['lang' => 'php'])
@verbatim
...
    'middleware_group' => ['web', 'auth:otherguard'],
...
@endverbatim
@endcomponent
