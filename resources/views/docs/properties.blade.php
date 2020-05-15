* [Introduction](#public-properties) { .text-blue-800 }
  * [Important Notes](#important-notes) { .font-normal.text-sm.text-blue-800 }
* [Initializing Properties](#initializing-properties) { .text-blue-800 }
* [Data Binding](#data-binding) { .text-blue-800 }
  * [Debouncing Input](#debouncing-input) { .font-normal.text-sm.text-blue-800 }
  * [Binding Nested Data](#binding-nested-data) { .font-normal.text-sm.text-blue-800 }
  * [Lazy Updating](#lazy-updating) { .font-normal.text-sm.text-blue-800 }
* [Updating The Query String](#query-string) { .text-blue-800 }
  * [Keeping A Clean Query String](#clean-query-string) { .font-normal.text-sm.text-blue-800 }
* [Casting Properties](#casting-properties) { .text-blue-800 }
  * [Custom Casters](#custom-casters) { .font-normal.text-sm.text-blue-800 }
* [Computed Properties](#computed-properties) { .text-blue-800 }

<div>&nbsp;</div>

@include('includes.screencast-cta')

## Public Properties {#public-properties}

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

@component('components.code-component', [
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
use Livewire\Component;

class HelloWorld extends Component
{
    public $message = 'Hello World!';

    public function render()
    {
        return view('livewire.hello-world');
    }
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

1. Data stored in public properties is made visible to the front-end JavaScript. Therefore, you SHOULD NOT store sensitive data in them.
2. Properties can ONLY be either a JavaScript-friendly data types (`string`, `int`, `array`, `boolean`), OR an eloquent model (or collection of models).

@component('components.warning')
<code>protected</code> and <code>private</code> properties DO NOT persist between Livewire updates. In general, you should avoid using them for storing state.
@endcomponent

## Initializing Properties {#initializing-properties}

You can initialize properties using the `mount` method of your component.

@component('components.code-component', ['className' => 'HelloWorld.php'])
@slot('class')
use Livewire\Component;

class HelloWorld extends Component
{
    public $message;

    public function mount()
    {
        $this->message = 'Hello World!';
    }

    public function render()
    {
        return view('livewire.hello-world');
    }
}
@endslot
@endcomponent

Livewire also makes a `$this->fill()` method available to you for cases where you have to set lots of properties and want to remove visual noise.

@component('components.code-component', ['className' => 'HelloWorld.php'])
@slot('class')
public function mount()
{
    $this->fill(['message' => 'Hello World!']);
}
@endslot
@endcomponent

Additionally, Livewire offers `$this->reset()` to programatically reset public property values to their initial state. This is useful for cleaning input fields after performing an action.

@component('components.code')Component
@slot('class')
public $name = '';

public function savePost()
{
    $this->post->update([
        'name' => $this->name,
    ]);

    $this->reset();
    // Will reset all public properties.

    $this->reset('name');
    // Will only reset the name property.
}
@endslot
@endcomponent

## Data Binding {#data-binding}
If you've used front-end frameworks like Vue, or Angular, you are already familiar with this concept. However, if you are new to this concept, Livewire can "bind" (or "synchronize") the current value of some HTML element with a specific property in your component.

@component('components.code-component', [
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class HelloWorld extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.hello-world');
    }
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

When using <code>wire:model</code> livewire binds the element both ways. This means the default value of the element comes from the livewire component, and as you change the value of your input, livewire will internally change the value of the component.

@component('components.code-component', [
    'className' => 'TwoWay.php',
    'viewName' => 'two-way.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class TwoWay extends Component
{
    public $selectExample = 'default';
    public $options = [
        'default' => 'A default option',
        'another' => 'Awesome choice',
        'yet-another' => 'Super amazing option',
    ];

    public $price = 200;

    public function render()
    {
        return view('livewire.two-way');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <p>A Select Example</p>
    <select wire:model="selectExample">
        @foreach($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    // Note there is no blade comparison in the option,
    // thats all handled internally by livewire

    <p>A Range Example</p>
    <input type="range" wire:model="price" min="50" max="300" step="50" />

    // If you add a "value" attribute, it will conflict with the range input.
    
</div>
@endverbatim
@endslot
@endcomponent

### Debouncing Input {#debouncing-input}

By default, Livewire applies a 150ms debounce to text inputs. This avoids too many network requests being sent as a user types into a text field.

If you wish to override this default (or add it to a non-text input), Livewire offers a "debounce" modifier. If you want to apply a half-second debounce to an input, you would include the modifier like so:

@component('components.code')
<input type="text" wire:model.debounce.500ms="name">
@endcomponent

### Binding Nested Data {#binding-nested-data}

Livewire supports binding to nested data inside arrays using dot notation:

@component('components.code')
<input type="text" wire:model="parent.message">
@endcomponent

### Lazy Updating {#lazy-updating}

By default, Livewire sends a request to the server after every `input` event (or `change` in some cases). This is usually fine for things like `<select>` elements that don't typically fire rapid updates, however, this is often unnecessary for text fields that update as the user types.

In those cases, use the `lazy` directive modifier to listen for the native "change" event.

@component('components.code')
<input type="text" wire:model.lazy="message">
@endcomponent

Now, the `$message` property will only be updated when the user clicks away from the input field.

## Updating The Query String {#query-string}

Sometimes it's useful to update the browser's query string when your component state changes.

For example, if you were building a "search posts" component, and wanted the query string to reflect the current search value like so:

`https://your-app.com/search-posts?search=some-search-string`

This way, when a user hits the back button, or bookmarks the page, you can get the initial state out of the query string, rather than resetting the component every time.

In these cases, you can add a property's name to `protected $updatesQueryString`, and Livewire will update the query string every time the property value changes.

@component('components.code-component', [
    'className' => 'SearchPosts.php',
    'viewName' => 'search-posts.blade.php',
])
@slot('class')
use Livewire\Component;

class SearchPosts extends Component
{
    public $search;

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.search-posts', [
            'posts' => Post::where('title', 'like', '%'.$this->search.'%')->get(),
        ]);
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <input wire:model="search" type="text" placeholder="Search posts by title...">

    <h1>Search Results:</h1>

    <ul>
        @foreach($posts as $post)
            <li>{{ $post->title }}</li>
        @endforeach
    </ul>
</div>
@endverbatim
@endslot
@endcomponent

### Keeping A Clean Query String {#clean-query-string}

In the case above, when the search property is empty, the query string will look like this:

`?search=`

There are other cases where you might want to only represent a value in the query string if it is NOT the default setting.

For example, if you have a `$page` property to track pagination in a component, you may want to remove the `page` property from the query string when the user is on the first page.

In cases like these, you can use the following syntax:

@component('components.code-component', ['className' => 'SearchPosts.php'])
@slot('class')
use Livewire\Component;

class SearchPosts extends Component
{
    public $foo;
    public $search = '';
    public $page = 1;

    protected $updatesQueryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->fill(request()->only('search', 'page'));
    }

    ...
}
@endslot
@endcomponent

## Casting Properties {#casting-properties}

Livewire offers an api to "cast" public properties to a more usable data type. Two common use-cases for this are working with date objects like `Carbon` instances, and dealing with Laravel collections:

@component('components.code', ['lang' => 'php'])
@verbatim
class CastedComponent extends Component
{
    public $options = ['foo', 'bar', 'bar'];
    public $expiresAt = 'tomorrow';
    public $formattedDate = 'today';

    protected $casts = [
        'options' => 'collection',
        'expiresAt' => 'date',
        'formattedDate' => 'date:m-d-y'
    ];

    public function getUniqueOptions()
    {
        return $this->options->unique();
    }

    public function getExpirationDateForHumans()
    {
        return $this->expiresAt->format('m/d/Y');
    }

    ...
@endverbatim
@endcomponent

### Custom Casters {#custom-casters}

Livewire allows you to build your own custom casters for custom use-cases. Implement the `Livewire\Castable` interface in a class and reference it in the `$casts` property:

@component('components.code', ['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    public $foo = ['bar', 'baz'];

    protected $casts = ['foo' => CollectionCaster::class];

    ...
@endverbatim
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Castable;

class CollectionCaster implements Castable
{
    public function cast($value)
    {
        return collect($value);
    }

    public function uncast($value)
    {
        return $value->all();
    }
}
@endverbatim
@endcomponent

## Computed Properties {#computed-properties}

Livewire offers an api for accessing dynamic properties. This is especially helpful for deriving properties from the database or another persistent store like a cache.

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

@component('components.code-component', [
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
@endcomponent

@component('components.tip')
Computed properties are cached for an individual Livewire request lifecycle. Meaning, if you call `$this->post` 5 times in a component's blade view, it won't make a seperate database query every time.
@endcomponent
