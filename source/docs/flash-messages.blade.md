---
title: Flash Messages
extends: _layouts.documentation
section: content
---

In cases where it's useful to "flash" a success or failure message to the user, Livewire supports Laravel's system for flashing data to the session.

Here's a common example of it's usage:

@codeComponent([
    'className' => 'UpdatePost.php',
    'viewName' => 'update-post.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class UpdatePost extends Component
{
    public $post;
    public $title;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
    }

    public function update()
    {
        $this->post->update([
            'title' => $this->title,
        ]);

        session()->flash('message', 'Post successfully updated.');
    }

    public function render()
    {
        return view('livewire.update-post');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="update">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    Title: <input wire:model="email" type="text">

    <button>Save</button>
</form>
@endverbatim
@endslot
@endcodeComponent

Now, after the user clicks "Save" and their post is updated, they will see "Post successfully updated" on the page.

If you wish to add flash data to a redirect and show the message on the destination page instead, Livewire is smart enough to persist the flash data for one more request. For example:

@codeComponent(['className' => 'UpdatePost.php'])
@slot('class')
@verbatim
...
public function update()
{
    $this->post->update([
        'title' => $this->title,
    ]);

    session()->flash('message', 'Post successfully updated.');

    return redirect()->to('/posts');
}
...
@endverbatim
@endslot
@endcodeComponent

Now when a user "Saves" a post, they will be redirected to the "/posts" endpoint and see the flash message there. This assumes the `/posts` page has the proper Blade snippet to display flash messages.
