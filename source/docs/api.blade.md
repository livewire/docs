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
`wire:click="foo"` | Listens for a "click" event, and fires the "foo" method in the component for a "click" event, and fires the "foo" method in the component
`wire:keydown.enter="foo"` | Listens for a keydown event with `Enter` as its key, and fires the "foo" method in the component for a "click" event, and fires the "foo" method in the component
`wire:foo="bar"` | Listens for an event called "foo". (You can specify any event you would like to listen for this way)
`wire:model="foo"` | Assuming `$foo` is a public property on the component class, every time an input element with this directive is updated, the property will be updated.
`wire:model.debounce.100ms="foo"` | Debounces the `input` events emitted by the element every 100 milliseconds
`wire:poll.500ms="foo"` | Livewire will run the "foo" method on the component class every 500 milliseconds
`wire:loading` | Assuming the element's CSS `display` property is `none`, this directive will set it to `block` while network requests are in transit
`wire:loading.class="foo"` | Will add the `foo` class to the element while network requests are happening
`wire:loading.class.remove="foo"` | Will remove the `foo` class while loading
`wire:loading.attr="disabled"` | Will add the `disabled="true"` attribute while loading
`wire:target="foo"` | Will scope `wire:loading` functionality to the element that has `wire:ref="foo"`
`wire:ref` | This directive is used as a way of referencing other elements from other directives (like `wire:loading`/`wire:target`)
