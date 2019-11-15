---
title: Troubleshooting
extends: _layouts.documentation
section: content
---

## Dom Diffing Issues

The most common issues encountered by Livewire users has to do with Livewire's DOM diffing/patching system. This is the system that selectively updates elements that been changed, added, or removed after every component update.

For the most part, this system is reliable, but there are certain cases where it is hard for it to keep track of things. When this happens, weird things happen to the component in the Browser.

### Symptoms;
* An input element looses focus
* A loading indicator mis-fires
* A previously interactive element becomes stale
* Transitions aren't applied to appropriate elements

### Cures:
* Add `wire:key` to elements inside loops:
@code
@verbatim
<ul>
    @foreach ($items as $item)
        <li wire:key="{{ $loop->index }}">{{ $item }}</li>
    @endforeach
</ul>
@endverbatim
@endcode

* Add `key()` to nested components in a loop
@code
@verbatim
<ul>
    @foreach ($items as $item)
        @livewire('view-item', $item, key($loop->index))
    @endforeach
</ul>
@endverbatim
@endcode

* Wrap Blade conditionals (`@@if`, `@@error`, `@@auth`) in an element
@code
@verbatim
<input type="text" wire:model="name">
<div> @error('name'){{ $message }}@enderror </div>
@endverbatim
@endcode

* Add `wire:key`. As a final measure, adding `wire:key` will directly tell Livewire how to keep track of a DOM element. Over-using this attribute is a smell, but it is very useful and powerful for problems of this nature.
@code
<div wire:key="foo">...</div>
<div wire:key="bar">...</div>
@endcode
