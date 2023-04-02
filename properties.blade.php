* [Introduction](#introduction)
  * [Important Notes](#important-notes)
* [Initializing Properties](#initializing-properties)
* [Data Binding](#data-binding)
  * [Binding Nested Data](#binding-nested-data)
  * [Debouncing Input](#debouncing-input)
  * [Lazy Updating](#lazy-updating)
  * [Deferred Updating](#deferred-updating)
* [Binding Directly To Model Properties](#binding-models)
* [Custom (Wireable) Properties](#wireable-properties)
* [Computed Properties](#computed-properties)

## Introduction {#introduction}

Livewire components store and track data as public properties on the component class.

@component('components.code', ['lang' => 'php'])
@verbatim
class HelloWorld extends Component
{
    public $message = 'Hello World!';
    ...
@endverbatim
@endcomponent

Public properties in Livewire are automatically made available to the view. No need to explicitly pass them into the view (although you can if you want).

@component('components.code-component')
@slot('class')
class HelloWorld extends Component
{
    public $message = 'Hello World!';
}
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $message }}</h1>
    <!-- Will output "Hello World!" -->
</div>
@endverbatim
@endslot
@endcomponent

### Important Notes {#important-notes}

Here are three ESSENTIAL things to note about public properties before embarking on your Livewire journey:

1. Property names can't conflict with property names reserved for Livewire (e.g. `rules` or `messages`)
2. Data stored in public properties is made visible to the front-end JavaScript. Therefore, you SHOULD NOT store sensitive data in them.
3. Properties can ONLY be either JavaScript-friendly data types (`string`, `int`, `array`, `boolean`), OR one of the following PHP types: `Stringable`, `Collection`, `DateTime`, `Model`, `EloquentCollection`.

@component('components.warning')
<code>protected</code> and <code>private</code> properties DO NOT persist between Livewire updates. In general, you should avoid using them for storing state.<br>
You should also note that while <code>null</code> data type is Javascript-friendly, <code>public</code> properties set to <code>null</code> DO NOT persist between Livewire updates.
@endcomponent

## Initializing Properties {#initializing-properties}

You can initialize properties using the `mount` method of your component.

@component('components.code-component')
@slot('class')
class HelloWorld extends Component
{
    public $message;

    public function mount()
    {
        $this->message = 'Hello World!';
    }
}
@endslot
@endcomponent

Livewire also makes a `$this->fill()` method available to you for cases where you have to set lots of properties and want to remove visual noise.

@component('components.code-component')
@slot('class')
public function mount()
{
    $this->fill(['message' => 'Hello World!']);
}
@endslot
@endcomponent

Additionally, Livewire offers `$this->reset()` and `$this->resetExcept()` to programmatically reset public property values to their initial state. This is useful for cleaning input fields after performing an action.

@component('components.code-component')
@slot('class')
public $search = '';
public $isActive = true;

public function resetFilters()
{
    $this->reset('search');
    // Will only reset the search property.

    $this->reset(['search', 'isActive']);
    // Will reset both the search AND the isActive property.

    $this->resetExcept('search');
    // Will only reset the isActive property (any property but the search property).
}
@endslot
@endcomponent

## Data Binding {#data-binding}
If you've used front-end frameworks like Vue, or Angular, you are already familiar with this concept. However, if you are new to this concept, Livewire can "bind" (or "synchronize") the current value of some HTML element with a specific property in your component.

@component('components.code-component')
@slot('class')
@verbatim
class HelloWorld extends Component
{
    public $message;
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <input wire:model="message" type="text">

    <h1>{{ $message }}</h1>
</div>
@endverbatim
@endslot
@endcomponent

When the user types something into the text field, the value of the `$message` property will automatically update.

Internally, Livewire will listen for an `input` event on the element, and when triggered, it will send an AJAX request to re-render the component with the new data.

@component('components.tip')
You can add <code>wire:model</code> to any element that dispatches an <code>input</code> event. Even custom elements, or third-party JavaScript libraries.
@endcomponent

Common elements to use `wire:model` on include:

Element Tag |
--- |
`<input type="text">` |
`<input type="radio">` |
`<input type="checkbox">` |
`<select>` |
`<textarea>` |

### Binding Nested Data {#binding-nested-data}

Livewire supports binding to nested data inside arrays using dot notation:

@component('components.code')
<input type="text" wire:model="parent.message">
@endcomponent

### Debouncing Input {#debouncing-input}

By default, Livewire applies a 150ms debounce to text inputs. This avoids too many network requests being sent as a user types into a text field.

If you wish to override this default (or add it to a non-text input), Livewire offers a "debounce" modifier. If you want to apply a half-second debounce to an input, you would include the modifier like so:

@component('components.code')
<input type="text" wire:model.debounce.500ms="name">
@endcomponent

### Lazy Updating {#lazy-updating}

By default, Livewire sends a request to the server after every `input` event (or `change` in some cases). This is usually fine for things like `<select>` elements that don't typically fire rapid updates, however, this is often unnecessary for text fields that update as the user types.

In those cases, use the `lazy` directive modifier to listen for the native `change` event.

@component('components.code')
<input type="text" wire:model.lazy="message">
@endcomponent

Now, the `$message` property will only be updated when the user clicks away from the input field.

### Deferred Updating {#deferred-updating}
In cases where you don't need data updates to happen live, Livewire has a `.defer` modifier that batches data updates with the next network request.

For example, given the following component:

@component('components.code', ['lang' => 'blade'])
<input type="text" wire:model.defer="query">
<button wire:click="search">Search</button>
@endcomponent

As the user types into the `<input>` field, no network requests will be sent. Even if the user clicks away from the input field and onto other fields on the page, no requests will be sent.

When the user presses "Search", Livewire will send ONE network request that contains both the new "query" state, AND the "search" action to perform.

This can drastically cut down on network usage when it's not needed.

## Binding Directly To Model Properties {#binding-models}

If an Eloquent model is stored as a public property on a Livewire component, you can bind to its properties directly. Here is an example component:

@component('components.code-component')
@slot('class')
use App\Post;

class PostForm extends Component
{
    public Post $post;

    protected $rules = [
        'post.title' => 'required|string|min:6',
        'post.content' => 'required|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        $this->post->save();
    }
}
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="save">
    <input type="text" wire:model="post.title">

    <textarea wire:model="post.content"></textarea>

    <button type="submit">Save</button>
</form>
@endverbatim
@endslot
@endcomponent

Notice in the above component we are binding directly to the "title" and "content" model attributes. Livewire will take care of hydrating and dehydrating the model between requests with the current, non-persisted data.

@component('components.warning')
Note: For this to work, you need to have a validation entry in the `$rules` property for any model attributes you want to bind to. Otherwise, an error will be thrown.
@endcomponent

Additionally, you can bind to models within an Eloquent Collection.

@component('components.code-component')
@slot('class')
use App\Post;

class PostForm extends Component
{
    public $posts;

    protected $rules = [
        'posts.*.title' => 'required|string|min:6',
        'posts.*.content' => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->posts = auth()->user()->posts;
    }

    public function save()
    {
        $this->validate();

        foreach ($this->posts as $post) {
            $post->save();
        }
    }
}
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="save">
    @foreach ($posts as $index => $post)
        <div wire:key="post-field-{{ $post->id }}">
            <input type="text" wire:model="posts.{{ $index }}.title">

            <textarea wire:model="posts.{{ $index }}.content"></textarea>
        </div>
    @endforeach

    <button type="submit">Save</button>
</form>
@endverbatim
@endslot
@endcomponent

Livewire also supports binding to relationships on Eloquent models like so:

@component('components.code-component')
@slot('class')
class EditUsersPosts extends Component
{
    public User $user;

    protected $rules = [
        'user.posts.*.title'
    ];

    public function save()
    {
		$this->validate();

        $this->user->posts->each->save();
    }
}
@endslot
@slot('view')
@verbatim
<div>
    @foreach ($user->posts as $i => $post)
        <input type="text" wire:model="user.posts.{{ $i }}.title" />

        <span class="error">
            @error('user.posts.'.$i.'.title') {{ $message }} @enderror
        </span>
    @endforeach

    <button wire:click="save">Save</button>
</div>
@endverbatim
@endslot
@endcomponent

## Custom (Wireable) Properties {#wireable-properties}

Sometimes you may want to set a component property to a non-model object that's available inside your app, like a DTO (Data Transfer Object).

For example, let’s say we have a custom object in our app called `Settings`. Rather than just store settings data as a plain array on our Livewire component, we can attach associated behavior to this data with a convenient wrapper object or DTO like `Settings`:

@component('components.code-component')
@slot('class')
class Settings implements Livewire\Wireable
{
    public $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    ...

    public function toLivewire()
    {
        return $this->items;
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }
}
@endslot
@endcomponent

Now you can freely use this object as a public property of your component as long as that object implements the `Livewire\Wireable` interface AND the property is typehinted like so:

@component('components.code-component')
@slot('class')
class SettingsComponent extends Livewire\Component
{
    public Settings $settings;

    public function mount()
    {
        $this->settings = new Settings([
            'foo' => 'bar',
        ]);
    }

    public function changeSetting()
    {
        $this->settings->foo = 'baz';
    }
}
@endslot
@endcomponent

And as you can see, changes to the component are persisted between requests because, with `Wireable`, Livewire knows how to “dehydrate” and “re-hydrate” this property on your component.

> If words like “hydrate” or “dehydrate” in the context of Livewire are fuzzy for you, [give this post a quick read](https://calebporzio.com/livewire-isnt-actually-live).

## Computed Properties {#computed-properties}

Livewire offers an API for accessing dynamic properties. This is especially helpful for deriving properties from the database or another persistent store like a cache.

@component('components.code', ['lang' => 'php'])
@verbatim
class ShowPost extends Component
{
    // Computed Property
    public function getPostProperty()
    {
        return Post::find($this->postId);
    }
@endverbatim
@endcomponent

Now, you can access `$this->post` from either the component's class or Blade view:

@component('components.code-component')
@slot('class')
class ShowPost extends Component
{
    public $postId;

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function deletePost()
    {
        $this->post->delete();
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
@endcomponent

@component('components.tip')
Computed properties are cached for an individual Livewire request lifecycle. Meaning, if you call `$this->post` 5 times in a component's blade view, it won't make a separate database query every time.
@endcomponent
