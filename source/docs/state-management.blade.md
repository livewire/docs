---
title: State Management
extends: _layouts.documentation
section: content
---

Livewire components store and track state using public class properties on the Component class.

@code(['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    // Public Property
    public $foo;
@endverbatim
@endcode

Here are some helpful points about public properties in Livewire.

@table
Public Properties |
--- |
Automatically available inside the component's Blade view. |
Can be used for data-binding (`public $foo;` can be bound via `wire:model="foo"`). |
Are sent back and forth with every network request (increase network payload). |
Should not store sensitive data. (any information stored in them will be visible to JavaScript). |
They MUST be of PHP type: `null`, `string`, `numeric`, `boolean`, or `array` (because JavaScript has to be able to understand them) OR an Eloquent Model or collection of Models |
@endtable

@warning
<code>protected</code> and <code>private</code> properties DO NOT persist between Livewire updates. In general, you should avoid using them for storing state.
@endwarning

### Initializing Properties {#initializing-properties}

You can initialize properties using the `mount` method/hook in Livewire. For example:

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
use Livewire\Component;

class HelloWorld extends Component
{
    public $message;

    public function mount()
    {
        $this->message = 'Hello ' . auth()->user()->first_name;
    }

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
</div>
@endverbatim
@endslot
@endcodeComponent

You can think of `mount()` like you would the `boot()` method of a Laravel Model, or the `created()` method of a Vue component.

### Updating The Query String {#update-query-string}

Sometimes it's useful to update the browser's query string when your component state changes.

For example, if you were building a "search posts" component, and wanted the query string to reflect the current search value like so:

`https://your-app.com/search-posts?search=some-search-string`

This way, when a user hits the back button, or the bookmarks the page, you can get the initial state out of the query string, rather than resetting the component every time.

In these cases, you can add the property's name to `protected $updatesQueryString`, and Livewire will update the query string every time the property value changes.

@codeComponent([
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
@endcodeComponent

### Casting Properties {#casting-properties}

Livewire offers an api to "cast" public properties to a more usable data type. Two common use-cases for this are working with date objects like `Carbon` instances, and dealing with Laravel collections:

@code(['lang' => 'php'])
@verbatim
class CastedComponent extends Component
{
    public $options = ['foo', 'bar', 'bar'];
    public $expiresAt = 'tomorrow';

    protected $casts = [
        'options' => 'collection',
        'expiresAt' => 'date',
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
@endcode

#### Custom Casters {#custom-casters}

Livewire allows you to build your own custom casters for custom use-cases. Implement the `Livewire\Castable` interface in a class and reference it in the `$casts` property:

@code(['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    public $foo = ['bar', 'baz'];

    protected $casts = ['foo' => CollectionCaster::class];

    ...
@endverbatim
@endcode

@code(['lang' => 'php'])
@verbatim
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
@endcode
