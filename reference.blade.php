Already familiar with Livewire and want to skip the long-form documentation? Here's a giant list of everything available in Livewire.

### Template Directives {#template-directives}
These are directives added to elements within Livewire component templates.

@component('components.code', ['lang' => 'blade'])
<button wire:click="save">...</button>
@endcomponent

@component('components.table')
Directive | Description
--- | ---
`wire:key="foo"` | Acts as a reference point for Livewire's DOM diffing system. Useful for adding/removing elements, and keeping track of lists.
`wire:click="foo"` | Listens for a "click" event, and fires the "foo" method in the component.
`wire:click.prefetch="foo"` | Listens for a "mouseenter" event, and "prefetches" the result of the "foo" method in the component. Then, if it is clicked, will swap in the "prefetched" result (without an extra request), if it's not clicked, will throw away the cached result.
`wire:keydown.enter="foo"` | Listens for a keydown event on the `enter` key, which fires the "foo" method in the component.
`wire:foo="bar"` | Listens for a browser event called "foo". (You can listen for *any* browser DOM event - not just those fired by Livewire).
`wire:model="foo"` | Assuming `$foo` is a public property on the component class, every time an input element with this directive is updated, the property synchronizes with its value.
`wire:model.debounce.100ms="foo"` | Debounces the `input` events emitted by the element every 100 milliseconds.
`wire:model.lazy="foo"` | Lazily syncs the input with its corresponding component property at rest.
`wire:model.defer="foo"` | Defers syncing the input with the Livewire property until an "action" is performed. This saves drastically on server roundtrips.
`wire:poll.500ms="foo"` | Runs the "foo" method on the component class every 500 milliseconds.
`wire:init="foo"` | Runs the "foo" method on the component immediately after it renders on the page.
`wire:loading` | Hides the element by default, and makes it visible while network requests are in transit.
`wire:loading.class="foo"` | Adds the `foo` class to the element while network requests are in transit.
`wire:loading.class.remove="foo"` | Removes the `foo` class while network requests are in transit.
`wire:loading.attr="disabled"` | Adds the `disabled="true"` attribute while network requests are in transit.
`wire:dirty` | Hides the element by default, and makes it visible while the element's state is "dirty" (different from what exists on the backend).
`wire:dirty.class="foo"` | Adds the `foo` class to the element while it's dirty.
`wire:dirty.class.remove="foo"` | Removes the `foo` class while the element is dirty.
`wire:dirty.attr="disabled"` | Adds the `disabled="true"` attribute while the element's dirty.
`wire:target="foo"` | Scopes `wire:loading` and `wire:dirty` functionality to a specific action.
`wire:ignore` | Instructs Livewire to not update the element or its children when updating the DOM from a server request. Useful when using third-party JavaScript libraries within Livewire components.
`wire:ignore.self` | The "self" modifier restricts updates to the element itself, but allows modifications to its children.
@endcomponent

### Alpine Component Object (`$wire`) {#alpine-component-object}

These are methods and properties available on the `$wire` object provided to Alpine components within a Livewire template. [Read Full Documentation](/docs/2.x/alpine-js)

@component('components.code', ['lang' => 'blade'])
<div x-data>
    <span x-show="$wire.showMessage">...</span>

    <button x-on:click="$wire.toggleShowMessage()">...</button>
</div>
@endcomponent

@component('components.table')
API | Description
--- | ---
`$wire.foo` | Get the value of the "foo" property on the Livewire component
`$wire.foo = 'bar'` | Set the value of the "foo" property on the Livewire component
`$wire.bar(..args)` | Call the "bar" method (with params) on the Livewire component
`let baz = await $wire.bar(..args)` | Call the "bar" method, but wait for the response and set `baz` to it
`$wire.on('foo', (..args) => {})` | Call a function when the "foo" event is emitted
`$wire.emit('foo', ...args)` | Emit the "foo" event to all Livewire components
`$wire.emitUp('foo', ...args)` | Emit the "foo" event to parent components
`$wire.emitSelf('foo', ...args)` | Emit the "foo" event only to this component
`$wire.get('foo')` | Get the "foo" property
`$wire.set('foo', 'bar')` | Set the "foo" property on the component
`$wire.call('foo', ..args)` | Call the "foo" method with params on the component
`x-data="{ foo: $wire.entangle('foo') }"` | Entagle the value of "foo" between Livewire and Alpine
`$wire.entangle('foo').defer` | Only update Livewire's "foo" next time a Livewire request is fired
@endcomponent

### Global Livewire JavaScript Object {#global-livewire-js}

These are methods available on the `window.Livewire` object in the frontend. These are for deeper Livewire interaction and customization.

@component('components.table')
Method | Description
--- | --- | ---
`Livewire.first()` | Get the first Livewire component's JS object on the page
`Livewire.find(componentId)` | Get a Livewire component by it's ID
`Livewire.all()` | Get all the Livewire components on a page
`Livewire.directive(directiveName, (el, directive, component) => {})` | Register a new Livewire directive (`wire:custom-directive`)
`Livewire.hook(hookName, (...) => {})` | Call a method when JS lifecycle hook is fired. [Read more](#js-hooks)
`Livewire.onLoad(() => {})` | Fires when Livewire is first finished loading on a page
`Livewire.onError((message, statusCode) => {})` | Fires when a Livewire request fails. You can `return false` from the callback to prevent Livewire's default behavior
`Livewire.emit(eventName, ...params)` | Emit an event to all Livewire components listening on a page
`Livewire.emitTo(componentName, eventName, ...params)` | Emit an event to specific component name
`Livewire.on(eventName, (...params) => {})` | Listen for an event to be emitted from a component
`Livewire.start()` | Boot Livewire on the page (done for you automatically via `@@livewireScripts`)
`Livewire.stop()` | Tear down Livewire from the page
`Livewire.restart()` | Stop, then start Livewire on the page
`Livewire.rescan()` | Re-scan the DOM for newly added Livewire components
@endcomponent

### JavaScript Hooks {#js-hooks}

These are "hooks" you can listen for in JavaScript. These allow you to hook into very specific parts of a Livewire component's JavaScript lifecycle for third-party packages or deep customizations. The abilities unlocked here are immense. A significant portion of Livewire's core uses these hooks to provide functionality.

@component('components.code', ['lang' => 'javascript'])
Livewire.hook('component.initialized', component => {
    //
})
@endcomponent

@component('components.table')
Name | Params | Description
--- | --- | ---
`component.initialized` | `(component)` | A new component has been initialized
`element.initialized` | `(el, component)` | A new element has been initialized
`element.updating` | `(fromEl, toEl, component)` | An element is about to be updated after a Livewire request
`element.updated` | `(el, component)` | An element has just been updated from a Livewire request
`element.removed` | `(el, component)` | An element has been removed after a Livewire request
`message.sent` | `(message, component)` | A new Livewire message was just sent to the server
`message.failed` | `(message, component)` | A Livewire ajax request (message) failed
`message.received` | `(message, component)` | A message has been received (but hasn't affected the DOM)
`message.processed` | `(message, component)` | A message has been fully received and implemented (DOM updates, etc...)
@endcomponent

### Component Class Lifecycle Hooks {#component-class-lifecycle}

These are methods you can declare in your Livewire component classes to run code at specific times in the backend's lifecycle. [Read Full Documentation](/docs/2.x/lifecycle-hooks)

@component('components.code', ['lang' => 'php'])
class ShowPost extends Component
{
    public function mount()
    {
        //
    }
}
@endcomponent

@component('components.table')
Name | Description
--- | ---
`boot()` | Called on all requests, immediately after the component is instantiated, but before any other lifecycle methods are called
`booted()` | Called on all requests, after the component is mounted or hydrated, but before any update methods are called
`mount(...$params)` | Called when a Livewire component is newed up (think of it like a constructor)
`hydrate()` | Called on subsequent Livewire requests after the component has been hydrated, but before any other action occurs
`hydrateFoo()` | Runs after a property called $foo is hydrated
`dehydrate()` | Called after `render()`, but before the component has been dehydrated and sent to the frontend
`dehydrateFoo()` | Runs before a property called $foo is dehydrated
`updating()` | Runs before any update to the Livewire component's data (Using wire:model, not directly inside PHP)
`updated($field, $newValue)` | Called after a property has been updated
`updatingFoo()` | Runs before a property called $foo is updated
`updatedFoo($newValue)` | Called after the "foo" property has been updated
`updatingFooBar()` | Runs before updating a nested property bar on the $foo property
`updatedFooBar($newValue)` | Called after the nested "bar" key on the "foo" property has been updated
`render()` | Called before "dehydrate" and renders the Blade view for the component
@endcomponent

### Component Class Protected Properties {#component-class-protected-properties}

Livewire provides core functionality through protected properties on a component's class. Most of these have corresponding methods by the same name if you prefer to return values in a method, rather than declare them as properties.

@component('components.code', ['lang' => 'php'])
class ShowPost extends Component
{
    protected $rules = ['foo' => 'required|min:6'];
}
@endcomponent

@component('components.table')
Name | Description
--- | ---
`$queryString` | Declare which properties to "bind" to the query sting. [Read Docs](/docs/2.x/query-string)
`$rules` | Specify validation rules to be applied to properties when calling `$this->validate()`. [Read Docs](/docs/2.x/input-validation)
`$listeners` | Specify which events you want to listen for emitted by other components. [Read Docs](/docs/2.x/events)
`$paginationTheme` | Specify whether you want to use Tailwind or Bootstrap for you pagination theme. [Read Docs](/docs/2.x/pagination)
@endcomponent

### Component Class Traits {#component-class-traits}

These are traits that unlock additional functionality in a Livewire component. Usually for features that are considered best as "opt-in".

@component('components.code', ['lang' => 'php'])
class ShowPost extends Component
{
    use WithPagination;
}
@endcomponent

@component('components.table')
Name | Description
--- | ---
`WithPagination` | This trait enables Livewire-based pagination instead of Laravel's stock pagination system. [Read Docs](/docs/2.x/pagination)
`WithFileUploads` | This trait enables adding `wire:model` to an input of `type="file"`. [Read Docs](/docs/2.x/file-uploads)
@endcomponent

### Class Methods {#class-methods}

@component('components.code', ['lang' => 'php'])
class PostForm extends Component
{
    public function save()
    {
        ...

        $this->emit('post-saved');
    }
}
@endcomponent

@component('components.table')
Name | Description
--- | ---
`$this->emit($eventName, ...$params)` | Emit an event to other components on the page
`$this->emitUp($eventName, ...$params)->up()` | Emit an event to parent components on the page
`$this->emitSelf($eventName, ...$params)->self()` | Emit an event only to THIS component
`$this->emitTo($eventName, ...$params)->to($componentName)` | Emit an event to any component matching the provided name
`$this->dispatchBrowserEvent($eventName, ...$params)` | Dispatch a browser event from this component's root element
`$this->validate()` | Run the validation rules provided in the `$rules` property against the public component properties
`$this->validate($rules, $messages)` | Run the provided validation rules against the public properties
`$this->validateOnly($propertyName)` | Run the `$rules` property validation against a specific property provided and not others
`$this->validateOnly($propertyName, $rules, $messages)` | Run the provided validation rules against a specific property name
`$this->redirect($url)` | Redirect to a new URL when the Livewire request finishes and reaches the frontend
`$this->redirectRoute($routeName)` | Redirect to a specific route name
`$this->skipRender()` | Skip running the `->render()` method for the current request. (Usually for performance reasons)
`$this->addError($name, $error)` | Add a specific error name and value to the component's error bag manually
`$this->resetValidation()` | Reset the currently stored validation errors (clear them)
`$this->fill([...$propertyData])` | Set public property names to provided values in bulk
`$this->reset()` | Reset all public properties to their initial (pre-mount) state
`$this->reset($field)` | Reset a specific public property to its pre-mount state
`$this->reset([...$fields])` | Reset multiple specific properties
`$this->all()` | Return key->value pairs of property data
`$this->only([...$propertyNames])` | Return key->value pairs of property data only for a specific set of property names
`$this->except([...$propertyNames])` | Return key->value pairs of property data except for a specific set of property names
@endcomponent

### PHP Testing Methods {#php-testing-methods}

These are methods available on Livewire's testing helpers. [Read Full Documentation](/docs/2.x/testing)

@component('components.code', ['lang' => 'php'])
public function test()
{
    Livewire::test(ShowPost::class)
        ->assertDontSee('bar')
        ->set('foo', 'bar')
        ->assertSee('bar');
}
@endcomponent

@component('components.table')
Name |
--- |
`->assertSet($propertyName, $value)` |
`->assertNotSet($propertyName, $value)` |
`->assertCount($propertyName, $value)` |
`->assertPayloadSet($propertyName, $value)` |
`->assertPayloadNotSet($propertyName, $value)` |
`->assertSee($string)` |
`->assertDontSee($string)` |
`->assertSeeHtml($string)` |
`->assertDontSeeHtml($string)` |
`->assertSeeHtmlInOrder([$firstString, $secondString])` |
`->assertSeeInOrder([$firstString, $secondString])` |
`->assertEmitted($eventName)` |
`->assertNotEmitted($eventName)` |
`->assertDispatchedBrowserEvent($eventName)` |
`->assertHasErrors($propertyName)` |
`->assertHasErrors($propertyName, ['required', 'min:6'])` |
`->assertHasNoErrors($propertyName)` |
`->assertHasNoErrors($propertyName, ['required', 'min:6'])` |
`->assertRedirect()` |
`->assertRedirect($url)` |
`->assertViewHas($viewDataKey)` |
`->assertViewHas($viewDataKey, $expectedValue)` |
`->assertViewHas($viewDataKey, function ($dataValue) {})` |
`->assertViewIs('livewire.some-view-name')` |
`->assertFileDownloaded($filename)` |
@endcomponent

There are also Laravel testing response helpers available to check the presence of a component on a given page.

@component('components.table')
Name |
--- |
`$response->assertSeeLivewire('some-component')` |
`$response->assertDontSeeLivewire('some-component')` |
@endcomponent

### Artisan Commands {#artisan-commands}

These are the `artisan` commands Livewire makes available to make frequent tasks like creating a component easier.

@component('components.table')
Name | Params | Description
--- | ---
`artisan make:livewire` | Create a new component
`artisan livewire:make` | Create a new component
`artisan livewire:copy` | Copy a component
`artisan livewire:move` | Move a component
`artisan livewire:delete` | Delete a component
`artisan livewire:touch` | Alias for `livewire:make`
`artisan livewire:cp` | Alias for `livewire:copy`
`artisan livewire:mv` | Alias for `livewire:move`
`artisan livewire:rm` | Alias for `livewire:delete`
`artisan livewire:stubs` | Publish Livewire stubs (used in the above commands) for local modification
`artisan livewire:publish` | Publish Livewire's config file to your project (`config/livewire.php`)
`artisan livewire:publish --assets` | Publish Livewire's config file AND its frontend assets to your project
`artisan livewire:configure-s3-upload-cleanup` | Configure your cloud disk driver's S3 bucket to clear temporary uploads after 24 hours
@endcomponent

### PHP Lifecycle Hooks {#php-lifecycle-hooks}

These are hooks provided by Livewire in PHP for listening to lifecycle occurences at a global level (not at a component level). These are used internally to provide a significant portion of Livewire's core functionality, and can be used in ServiceProviders to further extend Livewire yourself.

@component('components.code', ['lang' => 'php'])
Livewire::listen('component.hydrate', function ($component, $request) {
    //
});
@endcomponent

@component('components.table')
Name | Params | Description
--- | ---
`component.hydrate` | `($component, $request)` | Run on EVERY component hydration
`component.hydrate.initial` | `($component, $request)` | Run only on the INITIAL hydration (When the component is first loaded)
`component.hydrate.subsequent` | `($component, $request)` | Run only AFTER the initial component request
`component.dehydrate` | `($component, $response)` | Run on EVERY component dehydration
`component.dehydrate.initial` | `($component, $response)` | Run only on the INITIAL dehydration (When the component is first loaded)
`component.dehydrate.subsequent` | `($component, $response)` | Run on dehydrate AFTER the initial component request
`property.hydrate` | `($name, $value, $component, $request)` | Run when a specific property is hydrated
`property.dehydrate` | `($name, $value, $component, $response)` | Run when a specific property is dehydrated
@endcomponent
