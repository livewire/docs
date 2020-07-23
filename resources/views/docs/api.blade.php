
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
