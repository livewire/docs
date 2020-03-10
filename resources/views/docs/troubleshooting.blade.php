
## Dom Diffing Issues

The most common issues encountered by Livewire users has to do with Livewire's DOM diffing/patching system. This is the system that selectively updates elements that been changed, added, or removed after every component update.

For the most part, this system is reliable, but there are certain cases where Livewire is unable to properly track changes. When this happens, hopefully, a helpful error will be thrown and you can debug with the following guide.

### Symptoms:
* An input element looses focus
* An element or group of elements dissapears suddenly
* A previously interactive element stops responding to user input
* A loading indicator mis-fires

### Cures:
* Add `wire:key` to elements inside loops:
@component('components.code')
@verbatim
<ul>
    @foreach ($items as $item)
        <li wire:key="{{ $loop->index }}">{{ $item }}</li>
    @endforeach
</ul>
@endverbatim
@endcomponent

* Add `key()` to nested components in a loop
@component('components.code')
@verbatim
<ul>
    @foreach ($items as $item)
        @livewire('view-item', $item, key($loop->index))

        <!-- key() using Laravel 7's tag syntax -->
        <livewire:view-item :item="$item" :key="$loop->index">
    @endforeach
</ul>
@endverbatim
@endcomponent

* Wrap Blade conditionals (`@@if`, `@@error`, `@@auth`) in an element
@component('components.code')
@verbatim
<input type="text" wire:model="name">
<div> @error('name'){{ $message }}@enderror </div>
@endverbatim
@endcomponent

* Add `wire:key`. As a final measure, adding `wire:key` will directly tell Livewire how to keep track of a DOM element. Over-using this attribute is a smell, but it is very useful and powerful for problems of this nature.
@component('components.code')
<div wire:key="foo">...</div>
<div wire:key="bar">...</div>
@endcomponent
