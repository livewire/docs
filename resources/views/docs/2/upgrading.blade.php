## V2 Is Here! 🎉

Before we get into the technical upgrade stuff. You might be interested in what philosophical underpinnings are behind these changes.

* **Livewire is declarative.** Rather than providing an endless set of utilities for interacting with the front-end. Livewire aims to make front-end interactions a "side-effect" of your state (i.e. component properties). For example, with the new `$queryString` API, rather than providing methods to manually update the browsers query string from the backend, you declare which component properties you want to be reflected in the front-end's query string with the `$queryString` property.
* **Livewire is anti-boilerplate.** By allowing developers to set eloquent models as properties and `wire:model` (bind) to them directly, we're able to cut out SO much boilerplate code. To further kill the boilerplate, in V2, component parameters are now automatically assigned to public properties by matching their name. Now, `mount()` methods are only used for things they MUST be used for. Not for simply forwarding parameters to properties. Kill the noise.
* **Livewire is a back-end interface at its core**. The `wire:click` stuff is just sugar that makes the interface easy to use. With the addition of `$wire`, the underlying power is now apparent: Livewire allows you to interface with backend code, directly and declaratively without the need for imperative/boilerplatey patterns like axios.post(), RESTfull endpoints, controllers, etc...
* **Livewire is simple to use**. Of all the philosophies I hold. I hold this one the strongest. Livewire should always remain ridiculously easy to use. My goal is that you can easily remember and almost guess it's APIs. Before introducing any feature, I scour existing patterns and APIs in Laravel to see if Livewire can use that shared knowledge as leverage for new adopters. A small example is the new `$rules` property. I could have named it anything, but why would I name it anything besides `$rules` (A precedent set by Request objects in Laravel). If I don't think an API is easy, intuitive, and clear. I wait on the feature and let it simmer until something clear and beautiful emerges. (Or at least that's my goal.)

## Update Your Composer Version

1. Update the `livewire/livewire` dependency in your `composer.json` file to `^2.0`
2. Run `composer update livewire/livewire`
3. Run `php artisan view:clear`
4. Run `php artisan livewire:publish --assets` (If you published the assets before)

## Update Your Application Code

There are the following breaking changes and their upgrade instructions in order of impact.

1. [Updated: `$updatesQueryString` to `$queryString`](#query-string)
1. [Removed: Route::livewire()](#route-livewire)
1. [Removed: Turbolinks Support](#turbolinks)
1. [Changed: `assertSet()`](#assert-set)
1. [Removed: Property Casters](#casters)
1. [Updated: Pagination Views](#pagination)
1. [Updated: JavaScript Hooks](#hooks)

### Updated: `$updatesQueryString` to `$queryString` {#query-string}
Livewire 1.x had a more primitive utility for manipulating the browser's query string based on property values. In V2, there is a much more advanced utility for manipulating the query string.

The first breaking change is `$updatesQueryString` has been changed to `$queryString`:

@component('components.code', ['lang' => 'php'])
@verbatim
class Search extends Component
{
    // Before
    protected $updatesQueryString = ['search']

    // After
    protected $queryString = ['search']
}
@endverbatim
@endcomponent

Aside from a new property name, there are 2 significant changes to the inner workings:

1. Property values are now automatically set to intial values from the query string on page load
1. The query string system now uses the browser's `history.pushState` API instead of `history.replaceState` (which means you can now click the back button in a browser to revisit old query string changes)

Because the query string system now automatically sets initial values, there is no need for doing that in the `mount()` method anymore:

@component('components.code', ['lang' => 'php'])
@verbatim
class Search extends Component
{
    ...

    public function mount()
    {
        // No need for code like this anymore.
        // The search property will now be automatically set.
        $this->search = request()->query('search', '');
    }
}
@endverbatim
@endcomponent

### Removed: Route::livewire() {#route-livewire}
Livewire 1.x allowed you to register a component with a route for the entire page using the `Route::livewire()` method. Livewire 2.0 now allows you to pass Livewire components directly into routes using the standard `Route::get()` method and the fully qualified namespace.

@component('components.code', ['lang' => 'php'])
@verbatim
// Before
Route::livewire('/post', 'show-posts');

// After
Route::get('/post', \App\Http\Livewire\ShowPosts::class);
@endverbatim
@endcomponent

The first thing to note is that if you are using Laravel 7, you will need to remove the `namespace(...)` line from `app/Providers/RouteServiceProvider.php`:

@component('components.code', ['lang' => 'php'])
@verbatim
protected function mapWebRoutes()
{
    Route::middleware('web')
        ->namespace($this->namespace) // Remove me
        ->group(base_path('routes/web.php'));
}
@endverbatim
@endcomponent

This is done by default in Laravel 8, but if you are on Laravel 7, you will need to remove this to be able to pass a Livewire class into `Route::get()`. Otherwise, Laravel will prepend a namespace to ALL classes passed into `Route::get()`.

By default in 1.x, Livewire renders your page-level components using a traditional Blade layout located in `resources/layouts/app.blade.php`. In 2.0, Livewire uses the same layout file as a default, however, it now expects you are using the new Blade component `$slot` syntax in the layout. For example:

@component('components.code', ['lang' => 'html'])
@verbatim
<!-- Before -->
<html>
    <body>
        @yield('content')

        @livewireScripts
    </body>
</html>

<!-- After -->
<html>
    <body>
        {{ $slot }}

        @livewireScripts
    </body>
</html>
@endverbatim
@endcomponent

If you manually configured a layout for the route in your routes file, the `->layout()` method has now been moved to a new method called `->extends()` and placed in the render function.

@component('components.code', ['lang' => 'php'])
@verbatim
// Before
Route::livewire('/post', ShowPosts::class)
    ->layout('layouts.base')
    ->section('body');

// After
class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts')
            ->extends('layouts.base')
            ->section('body');
    }
}
@endverbatim
@endcomponent

If you wish to update your manually configured layouts to the new `$slot` syntax, you can specify them using the new `->layout()` method. This method will use the `$slot` by default, but you can also configure the component to render into a named slot using the `->slot()` method:

@component('components.code', ['lang' => 'php'])
@verbatim
class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts')
            ->layout('layouts.base')
            ->slot('body');
    }
}
@endverbatim
@endcomponent

## Removed: Turbolinks Support {#turbolinks}
Livewire no longer supports Turbolinks out of the box. There are plans in the future to implement our own alternative, but at the current time, providing support out of the box is out of Livewire's scope.

If a lack of Turbolinks support is a deal-breaker for your application, fear not. The Livewire V1 integration is surprisingly simple and isolated almost entirely to one chunk of code:
[View source on GitHub](https://github.com/livewire/livewire/commit/f7561d014b91c28e6e4774b9491c5dec00c7a711#diff-afbbb6430c73cf50cafea78549c61fd9L201)

Hopefully, this helps spur a community-driven Livewire-Turbolinks adapter in the near future.

## Changed: `assertSet()` {#assert-set}

In Livewire V1, the testing method `assertSet('property', 'value')` tested against data in the javascript-safe Livewire payload, rather than asserting against the value of a property on the actual Livewire component's PHP instance. This made it impossible to test computed properties from `assertSet()`.

In V2, `assertSet` now behaves how you would expect: making assertions on data in the actual PHP instance, and if you want to assert against payload data, you can now use the new `assertPayloadSet()`.

For most people, this won't change a thing. However, if during your upgrade you are getting failures in your test suite around an `assertSet()`, you should either refactor your test or use `assertPayloadSet()`.

## Removed: Property Casters {#casters}
Property casters have been removed in Livewire V2. There are three reasons for this decision:

1. People mostly used these for properties that are instances of `Collection` and `DateTime`. These are now automatically cast out of the box
1. Not many users use (or are even aware) of this feature to begin with
1. There are other ways to accomplish this exact same functionality

Here are a few examples:
@component('components.code', ['lang' => 'php'])
@verbatim
// Before
public $foo;

protected $casts = ['foo' => 'collection'];

public function mount()
{
    $this->foo = collect(['foo', 'bar']);
}

// After
// (Collections are automatically cast now)
public $foo;

public function mount()
{
    $this->foo = collect(['foo', 'bar']);
}
@endverbatim
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
// Before
class AllCaps implements Castable {
    public function cast($value)
    {
        return strtoupper($value);
    }

    public function uncast($value)
    {
        return strtolower($value);
    }
}

class SomeComponent extends Component
{
    public $foo;

    protected $casts = ['foo' => AllCaps::class];

    ....
}

// After
class SomeComponent extends Component
{
    public $foo;

    public function hydrateFoo()
    {
        $this->foo = strtoupper($value);
    }

    public function dehydrateFoo()
    {
        $this->foo = strtolower($value);
    }

    ....
}
@endverbatim
@endcomponent

## Updated: Pagination Views {#pagination}
If you've paginated results by adding `WithPagination` to a component and relied upon the default Livewire pagination links view using `$posts->links()`, the views will have been updated from Bootstrap-4 to Tailwind.

Livewire V2 still supports Bootstrap-4 pagination, however, you have to configure it using the `$paginationTheme` property on your component:

@component('components.code', ['lang' => 'php'])
@verbatim
class ShowPosts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    ...
}
@endverbatim
@endcomponent

Even though V2 still supports Bootstrap-4, the pagination view has been updated to match Laravel 8. Therefore, it will differ slightly from the view previously used in V1. To use the exact view from V1:

1. Copy the view source [from GitHub](https://raw.githubusercontent.com/livewire/livewire/1.x/src/views/pagination-links.blade.php)
2. Paste it into a new blade file anywhere you see fit. For example, we'll say: `resources/views/pagination-links.blade.php`
3. Now reference it in your Blade view by passing it into the `->links()` method:

@component('components.code', ['lang' => 'php'])
@verbatim
{{ $posts->links('pagination-links') }}
@endverbatim
@endcomponent

## Updated: JavaScript Hooks {#hooks}
V2 Offers the same JavaScript hooks as V1, but with three distinct updates:

1. Their names are different
1. The parameter orders have been updated to be more consistent
1. In places where an instance of the "DomElement" wrapper was passed, now a native DOM element is passed

Here are the hook usages side by side for comparison:

| V1 Names | V2 Names / Usages |
| --- | --- |
| `livewire.hook('componentInitialized', (component) => {})` | `Livewire.hook('component.initialized', (component) => {})` |
| `livewire.hook('elementInitialized', (el, component) => {})` | `Livewire.hook('element.initialized', (el, component) => {})` |
| `livewire.hook('beforeElementUpdate', (from, to, component) => {})` | `Livewire.hook('element.updating', (fromEl, toEl, component) => {})` |
| `livewire.hook('afterElementUpdate', (node, component) => {})` | `Livewire.hook('element.updated', (el, component) => {})` |
| `livewire.hook('elementRemoved', (el, component) => {})` | `Livewire.hook('element.removed', (el, component) => {})` |
| `livewire.hook('messageSent', (component, message) => {})` | `Livewire.hook('message.sent', (message, component) => {})` |
| `livewire.hook('messageFailed', (component) => {})` | `Livewire.hook('message.failed', (message, component) => {})` |
| `livewire.hook('responseReceived', (component, response) => {})` | `Livewire.hook('message.received', (message, component) => {})` |
| `livewire.hook('afterDomUpdate', (component) => {})` | `Livewire.hook('message.processed', (message, component) => {})` |
| `livewire.hook('beforeDomUpdate', (component) => {})` | _Removed in V2_ |

*Note: in some instances, a `message` object is now passed in instead of a `response` object. `response` can be accessed as a property of `message`: `message.response`*

## Signing Off
Hopefully, the impact of this upgrade isn't much for you.

If you have questions or corrections to make to this document, please [submit a GitHub issue on the repository.](https://github.com/livewire/livewire/issues/new/choose)

As always, thanks for your support and thanks for using Livewire!

- Caleb
