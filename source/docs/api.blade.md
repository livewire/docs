---
title: API Reference
description: todo
extends: _layouts.documentation
section: content
---

# API Reference

## Template API

### Directives
Directive | Description
--- | ---
`wire:key="foo"` | Acts as a reference point for Livewire's DOM diffing system. Useful for adding/removing elements, and keeping track of lists.
`wire:click="foo"` | Listens for a "click" event, and fires the "foo" method in the component for a "click" event, and fires the "foo" method in the component
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
