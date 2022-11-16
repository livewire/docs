* [Introduction](#introduction)
* [Testing Component Presence](#testing-component-presence)
* [Testing With Query String Parameters](#testing-querystring)
* [Testing Components With Passed Data](#testing-passed-data)
* [Generating Tests](#generating-tests)
* [All Available Test Methods](#all-testing-methods)

## Introduction {#introduction}

Livewire offers a powerful set of tools for testing your components.

Here's a Livewire component and a corresponding test to demonstrate the basics.

@component('components.code-component')
@slot('class')
@verbatim
class CreatePost extends Component
{
    public $title;

    protected $rules = [
        'title' => 'required',
    ];

    public function create()
    {
        auth()->user()->posts()->create(
            $this->validate()
        );

        return redirect()->to('/posts');
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
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class)
            ->set('title', 'foo')
            ->call('create');

        $this->assertTrue(Post::whereTitle('foo')->exists());
    }

    /** @test */
    function can_set_initial_title()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class, ['initialTitle' => 'foo'])
            ->assertSet('title', 'foo');
    }

    /** @test */
    function title_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class)
            ->set('title', '')
            ->call('create')
            ->assertHasErrors(['title' => 'required']);
    }

    /** @test */
    function is_redirected_to_posts_page_after_creation()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class)
            ->set('title', 'foo')
            ->call('create')
            ->assertRedirect('/posts');
    }
}
@endcomponent

## Testing Component Presence {#testing-component-presence}

Livewire registers handy PHPUnit methods for testing a components presence on a page.

@component('components.code', ['lang' => 'php'])
class CreatePostTest extends TestCase
{
    /** @test */
    function post_creation_page_contains_livewire_component()
    {
        $this->get('/posts/create')->assertSeeLivewire('create-post');
    }

    /** @test */
    function post_creation_page_doesnt_contain_livewire_component()
    {
        $this->get('/posts/create')->assertDontSeeLivewire('edit-post');
    }
}
@endcomponent

Alternatively, you may pass a component's class name to the `assertSeeLivewire` and `assertDontSeeLivewire` methods.

@component('components.code', ['lang' => 'php'])
use App\Http\Livewire\CreatePost;
use App\Http\Livewire\EditPost;

class CreatePostTest extends TestCase
{
    /** @test */
    function post_creation_page_contains_livewire_component()
    {
        $this->get('/posts/create')->assertSeeLivewire(CreatePost::class);
    }

    /** @test */
    function post_creation_page_doesnt_contain_livewire_component()
    {
        $this->get('/posts/create')->assertDontSeeLivewire(EditPost::class);
    }
}
@endcomponent

## Testing With Query String Parameters {#testing-querystring}

To test Livewire's `$queryString` functionality, you can use Livewire's `::withQueryParams` testing utility.

@component('components.code', ['lang' => 'php'])
class CreatePostTest extends TestCase
{
    /** @test */
    function post_creation_page_contains_livewire_component()
    {
        Livewire::withQueryParams(['foo' => 'bar'])
            ->test(ShowFoo::class)
            ->assertSet('foo', 'bar')
            ->assertSee('bar');
    }
}
@endcomponent

## Testing Components With Passed Data {#testing-passed-data}

@component('components.code-component')
@slot('view')
@verbatim
<livewire:show-foo foo="bar">
@endverbatim
@endslot
@slot('class')
class CreatePostTest extends TestCase
{
    /** @test */
    function has_data_passed_correctly()
    {
        Livewire::test(ShowFoo::class, ['foo' => 'bar'])
            ->assertSet('foo', 'bar')
            ->assertSee('bar');
    }
}
@endslot
@endcomponent

## Generating Tests {#generating-tests}

When creating a component, you can include the `--test` flag, and a test file will be created for you as well.

@component('components.code', ['lang' => 'shell'])
php artisan make:livewire ShowPosts --test
@endcomponent

@component('components.code-component', ['lang' => 'php', 'className' => 'tests/Feature/Livewire/ShowPostsTest.php'])
@slot('class')
class ShowPostsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ShowPosts::class);

        $component->assertStatus(200);
    }
}
@endslot
@endcomponent

## All Available Test Methods {#all-testing-methods}

@component('components.code', ['lang' => 'php'])
Livewire::actingAs($user);
// Set the provided user as the session's logged in user for the test

Livewire::withQueryParams(['foo' => 'bar']);
// Set the query param "foo" to "bar" for the Livewire component's `$queryString` property to pick up.

Livewire::test('foo', ['bar' => $bar]);
// Test the "foo" component with "bar" set as a parameter.

->set('foo', 'bar');
// Set the "foo" property (`public $foo`) to the value: "bar"

->toggle('foo');
// Toggle the "foo" property (`public $foo`) between true and false

->call('foo');
// Call the "foo" method

->call('foo', 'bar', 'baz');
// Call the "foo" method, and pass the "bar" and "baz" parameters

->emit('foo');
// Fire the "foo" event

->emit('foo', 'bar', 'baz');
// Fire the "foo" event, and pass the "bar" and "baz" parameters

->assertSet('foo', 'bar');
// Asserts that the "foo" property is set to the value "bar" (Includes computed properties)

->assertNotSet('foo', 'bar');
// Asserts that the "foo" property is NOT set to the value "bar" (Includes computed properties)

->assertCount('foo', 1);
// Asserts that the "foo" property (an array) has a count of 1 (Includes computed properties)

->assertPayloadSet('foo', 'bar');
// Asserts that the "foo" property from the JavaScript payload that Livewire returns is set to the value "bar"

->assertPayloadNotSet('foo', 'bar');
// Asserts that the "foo" property in the JavaScript payload that Livewire returns is NOT set to the value "bar"

->assertViewIs('foo');
// Assert that the view "foo" is the currently rendered view

->assertViewHas('foo', 'bar');
// Assert that the rendered view has a key of "foo" with a value of "bar"

->assertSee('foo');
// Assert that the string "foo" exists in the currently rendered content of the component

->assertDontSee('foo');
// Assert that the string "foo" DOES NOT exist in the currently rendered content of the component

->assertSeeHtml('<h1>foo</h1>');
// Assert that the string "<h1>foo</h1>" exists in the currently rendered HTML of the component

->assertDontSeeHtml('<h1>foo</h1>');
// Assert that the string "<h1>foo</h1>" DOES NOT exist in the currently rendered HTML of the component

->assertSeeInOrder(['foo', 'bar']);
// Assert that the string "foo" exists before "bar" in the currently rendered content of the component

->assertSeeHtmlInOrder(['<h1>foo</h1>', '<h1>bar</h1>']);
// Assert that the string "<h1>foo</h1>" exists before "<h1>bar</h1>" in the currently rendered content of the component

->assertEmitted('foo');
// Assert that the "foo" event was emitted

->assertEmitted('foo', 'bar', 'baz');
// Assert that the "foo" event was emitted with the "bar" and "baz" parameters

->assertNotEmitted('foo');
// Assert that the "foo" event was NOT emitted

->assertEmittedTo('bar','foo');
// Assert that the "foo" event was emitted to "bar" component

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

->assertNoRedirect();
// Assert that no redirect was triggered from the component

->assertUnauthorized();
// Assert that an error within the component caused an error with the status code: 401

->assertForbidden();
// Assert that an error within the component caused an error with the status code: 403

->assertStatus(500);
// Assert that an error within the component caused an error with the status code: 500

->assertDispatchedBrowserEvent('event', $data);
// Assert that a browser event was dispatched from the component using (->dispatchBrowserEvent(...))

->assertNotDispatchedBrowserEvent('event');
// Assert that a browser event was not dispatched from the component using (->dispatchBrowserEvent(...))

->assertFileDownloaded($filename)
// Assert that a downloaded file was returned with a specific name
@endcomponent
