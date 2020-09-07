Already familiar with Livewire and want to skip the long-form documentation? Here's a giant list of everything available in Livewire.

### Template Directives
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
`wire:model.defer="foo"` | Deferrs syncing the input with the Livewire property until an "action" is performed. This saves drastically on server roundtrips.
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

### JS Component Object (`$wire`)
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

### Global JS Livewire Object (`window.Livewire`)
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

### JS Hooks {#js-hooks}

**Usage:** `Livewire.hook([hook], ([params]) => { ... })`

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

### PHP Component Lifecycle Hooks
@component('components.table')
Name | Description
--- | ---
`hydrate()` | Called on subsequent Livewire requests after the component has been hydrated, but before any other action occurs
`mount(...$params)` | Called when a Livewire component is newed up (think of it like a constructor)
`updated($field, $newValue)` | Called after a property has been updated
`updatedFoo($newValue)` | Called after the "foo" property has been updated
`render()` | Called before "dehydrate" and renders the Blade view for the component
`dehydrate()` | Called after `render()`, but before the component has been dehydrated and sent to the frontend
@endcomponent

### Component Protected Properties
@component('components.table')
Name | Params | Description
--- | ---
`$queryString` |
`$rules` |
`$listeners` |
`$listeners` |
`$paginationTheme` |
@endcomponent

### PHP Traits
@component('components.table')
Name | Params | Description
--- | ---
`WithPagination` |
`WithFileUploads` |
@endcomponent

### Class Methods
@component('components.table')
Name | Params | Description
--- | ---
`$this->emit($eventName, ...$params)` |
`$this->emit($eventName, ...$params)->up()` |
`$this->emit($eventName, ...$params)->self()` |
`$this->emit($eventName, ...$params)->to($componentName)` |
`$this->dispatchBrowserEvent($eventName, ...$params)` |
`$this->validate()` |
`$this->validate($rules, $messages)` |
`$this->validateOnly($field)` |
`$this->validateOnly($field, $rules, $messages)` |
`$this->redirect($url)` |
`$this->redirectRoute($routeName)` |
`$this->skipRender()` |
`$this->addError($name, $error)` |
`$this->resetValidation()` |
`$this->fill([...$propertyData])` |
`$this->reset()` |
`$this->reset($field)` |
`$this->reset([...$fields])` |
`$this->only([...$propertyNames])` |
@endcomponent

### PHP Testing Methods
@component('components.table')
Name | Params | Description
--- | ---
`->assertSet($propertyName, $value)` |
`->assertNotSet($propertyName, $value)` |
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
@endcomponent

### Artisan Commands
@component('components.table')
Name | Params | Description
--- | ---
`artisan make:livewire` |
`artisan livewire:make` |
`artisan livewire:copy` |
`artisan livewire:move` |
`artisan livewire:delete` |
`artisan livewire:touch` |
`artisan livewire:cp` |
`artisan livewire:mv` |
`artisan livewire:rm` |
`artisan livewire:stubs` |
`artisan livewire:publish` |
`artisan livewire:configure-s3-upload-cleanup` |
@endcomponent

### PHP Lifecycle Hooks
@component('components.table')
Name | Params | Description
--- | ---
`component.hydrate` | `($component, $request)`
`component.hydrate.initial` | `($component, $request)`
`component.hydrate.subsequent` | `($component, $request)`
`component.dehydrate` | `($component, $response)`
`component.dehydrate.initial` | `($component, $response)`
`component.dehydrate.subsequent` | `($component, $response)`
`property.hydrate` | `($name, $value, $component, $request)`
`property.dehydrate` | `($name, $value, $component, $response)`
@endcomponent
