---
title: API Reference
extends: _layouts.documentation
section: content
---

## Template API

### Directives
Directive | Description
--- | ---
`wire:key="foo"` | Acts as a reference point for Livewire's DOM diffing system. Useful for adding/removing elements, and keeping track of lists.
`wire:click="foo"` | Listens for a "click" event, and fires the "foo" method in the component for a "click" event, and fires the "foo" method in the component
`wire:click.prefetch="foo"` | Listens for a "mouseenter" event, and "prefetches" the result of the "foo" method in the component. Then, if it is clicked, will swap in the "prefetched" result (without an extra request), if it's not clicked, will throw away the cached result.
`wire:keydown.enter="foo"` | Listens for a keydown event with `Enter` as its key, and fires the "foo" method in the component for a "click" event, and fires the "foo" method in the component
`wire:foo="bar"` | Listens for a browser event called "foo". (You can specify any browser DOM event (not Livewire events) you would like to listen for this way)
`wire:model="foo"` | Assuming `$foo` is a public property on the component class, every time an input element with this directive is updated, the property will be updated.
`wire:model.debounce.100ms="foo"` | Debounces the `input` events emitted by the element every 100 milliseconds
`wire:poll.500ms="foo"` | Livewire will run the "foo" method on the component class every 500 milliseconds
`wire:init="foo"` | Livewire will run the "foo" method on the component immediately after it renders on the page
`wire:loading` | Will hide the element by default, but show it while network requests are in transit
`wire:loading.class="foo"` | Will add the `foo` class to the element while network requests are happening
`wire:loading.class.remove="foo"` | Will remove the `foo` class while loading
`wire:loading.attr="disabled"` | Will add the `disabled="true"` attribute while loading
`wire:dirty` | Will hide the elemeny by default, but show it while the element's "state" is dirty (different from what exists on the backend)
`wire:dirty.class="foo"` | Will add the `foo` class to the element while element is dirty
`wire:dirty.class.remove="foo"` | Will remove the `foo` class while dirty
`wire:dirty.attr="disabled"` | Will add the `disabled="true"` attribute while dirty
`wire:target="foo"` | Will scope `wire:loading` and `wire:dirty` functionality to the element that has `wire:ref="foo"`
`wire:ref` | This directive is used as a way of referencing other elements from other directives (like `wire:loading`/`wire:dirty` and `wire:target`)
`wire:ignore` | Adding this directive to an element will tell Livewire to not update it or it's children when updating the DOM from a server request. Useful when using Third-party javascript libraries in Livewire components.
`wire:ignore.self` | The "self" modifier ignores updates to the element itself, but allows modifications to children.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/280f8c14691a46dbcb82ab5506128e87b460170e.blade.md ENDPATH**/ ?>