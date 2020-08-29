
Livewire offers a powerful set of tools for testing your components.

Here's a Livewire component and a corresponding test to demonstrate the basics.

@component('components.code-component', [
    'className' => 'CreatePost',
    'viewName' => 'create-post.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class CreatePost extends Component
{
    public $title;

    public function mount($initialTitle = '')
    {
        $this->title = $initialTitle;
    }

    public function create()
    {
        auth()->user()->posts()->create($this->validate([
            'title' => 'required',
        ]);

        return redirect()->to('/posts');
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="create">
    <input wire:model="title" type="text">

    <button>Create Post</button>
</form>
@endverbatim
@endslot
@endcomponent

@component('components.code', ['lang' => 'php'])
class CreatePostTest extends TestCase
{
    /** @test */
    function can_create_post()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(CreatePost::class)
            ->set('title', 'foo')
            ->call('create');

        $this->assertTrue(Post::whereTitle('foo')->exists());
    }

    /** @test */
    function can_set_initial_title()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(CreatePost::class, ['initialTitle' => 'foo'])
            ->assertSet('title', 'foo');
    }

    /** @test */
    function title_is_required()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(CreatePost::class)
            ->set('title', '')
            ->call('create')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    function is_redirected_to_posts_page_after_creation()
    {
        $this->actingAs(factory(User::class)->create());

        Livewire::test(CreatePost::class)
            ->set('title', 'foo')
            ->call('create')
            ->assertRedirect('/posts');
    }
}
@endcomponent

## Testing Component Presence {#testing-component-presence}

Livewire registers a handy PHPUnit method to test for a component's presence on a page.

@component('components.code', ['lang' => 'php'])
class CreatePostTest extends TestCase
{
    /** @test */
    function post_creation_page_contains_livewire_component()
    {
        $this->get('/posts/create')->assertSeeLivewire('create-post');
    }
}
@endcomponent

## All Available Test Methods {#all-testing-methods}

@component('components.code', ['lang' => 'php'])
Livewire::actingAs($user);
// Set the provided user as the session's logged in user for the test

Livewire::test('foo', ['bar' => $bar]);
// Test the "foo" component with "bar" set as a parameter.

->set('foo', 'bar');
// Set the "foo" property (`public $foo`) to the value: "bar"

->call('foo');
// Call the "foo" method

->call('foo', 'bar', 'baz');
// Call the "foo" method, and pass the "bar" and "baz" parameters

->emit('foo');
// Fire the "foo" event

->emit('foo', 'bar', 'baz');
// Fire the "foo" event, and pass the "bar" and "baz" parameters

->assertSet('foo', 'bar');
// Asserts that the "foo" property is set to the value "bar"

->assertNotSet('foo', 'bar');
// Asserts that the "foo" property is NOT set to the value "bar"

->assertSee('foo');
// Assert that the string "foo" exists in the currently rendered content of the component

->assertDontSee('foo');
// Assert that the string "foo" DOES NOT exist in the currently rendered content of the component

->assertSeeHtml('<h1>foo</h1>');
// Assert that the string "<h1>foo</h1>" exists in the currently rendered HTML of the component

->assertDontSeeHtml('<h1>foo</h1>');
// Assert that the string "<h1>foo</h1>" DOES NOT exist in the currently rendered HTML of the component

->assertSeeHtml('<div></div>');
// Assert that the string "<div></div>" exists in the currently rendered HTML of the component

->assertDontSeeHtml('<div></div>');
// Assert that the string "<div></div>" DOES NOT exist in the HTML

->assertEmitted('foo');
// Assert that the "foo" event was emitted

->assertEmitted('foo', 'bar', 'baz');
// Assert that the "foo" event was emitted with the "bar" and "baz" parameters

->assertNotEmitted('foo');
// Assert that the "foo" event was NOT emitted

->assertHasErrors('foo');
// Assert that the "foo" property has validation errors

->assertHasErrors(['foo', 'bar']);
// Assert that the "foo" AND "bar" properties have validation errors

->assertHasErrors(['foo' => 'required']);
// Assert that the "foo" property has a "required" validation rule error

->assertHasErrors(['foo' => ['required', 'min']]);
// Assert that the "foo" property has a "required" AND "min" validation rule error

->assertHasNoErrors('foo');
// Assert that the "foo" property has no validation errors

->assertHasNoErrors(['foo', 'bar']);
// Assert that the "foo" AND "bar" properties have no validation errors

->assertNotFound();
// Assert that an error within the component caused an error with the status code: 404

->assertRedirect('/some-path');
// Assert that a redirect was triggered from the component

->assertUnauthorized();
// Assert that an error within the component caused an error with the status code: 401

->assertForbidden();
// Assert that an error within the component caused an error with the status code: 403

->assertStatus(500);
// Assert that an error within the component caused an error with the status code: 500

->assertDispatchedBrowserEvent('event', $data);
// Assert that a browser event was dispatched from the component using (->dispatchBrowserEvent(...))

@endcomponent
