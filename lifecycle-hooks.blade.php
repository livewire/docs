@include('includes.screencast-cta')

## Class Hooks

Each Livewire component undergoes a lifecycle. Lifecycle hooks allow you to run code at any part of the component's lifecyle, or before specific properties are updated.

@component('components.table')
Hooks | Description
--- | ---
mount | Runs once, immediately after the component is instantiated, but before `render()` is called
hydrate | Runs on every request, after the component is hydrated, but before an action is performed, or `render()` is called
hydrateFoo | Runs after a property called `$foo` is hydrated
dehydrate | Runs on every request, before the component is dehydrated, but after `render()` is called
dehydrateFoo | Runs before a property called `$foo` is dehydrated
updating | Runs before any update to the Livewire component's data (Using `wire:model`, not directly inside PHP)
updated | Runs after any update to the Livewire component's data (Using `wire:model`, not directly inside PHP)
updatingFoo | Runs before a property called `$foo` is updated. Array properties have an additional `$key` argument passed to this function to specify changing element inside array, like `updatingArray($value, $key)`
updatedFoo | Runs after a property called `$foo` is updated. Array properties have additional `$key` argument as above
updatingFooBar | Runs before updating a nested property `bar` on the `$foo` property or a multiword property such as `$fooBar` or `$foo_bar`
updatedFooBar | Runs after updating a nested property `bar` on the `$foo` property or a multiword property such as `$fooBar` or `$foo_bar`
@endcomponent

@component('components.warning')
Please note that mutating a property directly inside a Livewire component class doesn't trigger any of the updating/updated hooks.
@endcomponent

@component('components.code', ['lang' => 'php'])
class HelloWorld extends Component
{
    public $foo;

    public function mount()
    {
        //
    }

    public function hydrateFoo($value)
    {
        //
    }

    public function dehydrateFoo($value)
    {
        //
    }

    public function hydrate()
    {
        //
    }

    public function dehydrate()
    {
        //
    }

    public function updating($name, $value)
    {
        //
    }

    public function updated($name, $value)
    {
        //
    }

    public function updatingFoo($value)
    {
        //
    }

    public function updatedFoo($value)
    {
        //
    }

    public function updatingFooBar($value)
    {
        //
    }

    public function updatedFooBar($value)
    {
        //
    }
}
@endcomponent

## Javascript Hooks {#js-hooks}

Livewire gives you the opportunity to execute javascript during certain events.

@component('components.table')
Hooks | Description
--- | ---
component.initialized | Called when a component has been initialized on the page by Livewire
element.initialized | Called when Livewire initializes an individual element
element.updating | Called before Livewire updates an element during its DOM-diffing cycle after a network roundtrip
element.updated | Called after Livewire updates an element during its DOM-diffing cycle after a network roundtrip
element.removed | Called after Livewire removes an element during its DOM-diffing cycle
message.sent | Called when a Livewire update triggers a message sent to the server via AJAX
message.failed | Called if the message send fails for some reason
message.received | Called when a message has finished its roudtrip, but before Livewire updates the DOM
message.processed | Called after Livewire processes all side effects (including DOM-diffing) from a message
@endcomponent


@component('components.code', ['lang' => 'js'])
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('component.initialized', (component) => {})
        Livewire.hook('element.initialized', (el, component) => {})
        Livewire.hook('element.updating', (fromEl, toEl, component) => {})
        Livewire.hook('element.updated', (el, component) => {})
        Livewire.hook('element.removed', (el, component) => {})
        Livewire.hook('message.sent', (message, component) => {})
        Livewire.hook('message.failed', (message, component) => {})
        Livewire.hook('message.received', (message, component) => {})
        Livewire.hook('message.processed', (message, component) => {})
    });
</script>
@endcomponent
