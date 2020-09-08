
## Dom Diffing Issues

The most common issues encountered by Livewire users has to do with Livewire's DOM diffing/patching system. This is the system that selectively updates elements that have been changed, added, or removed after every component update.

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
        @livewire('view-item', ['item' => $item], key($loop->index))

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

## Checksum Issues

On every request, Livewire does a "[checksum](https://laravel-livewire.com/docs/security)" but in some cases with arrays, it can throw an exception even when the data inside the array is the same.

Because in PHP an array can have keys that are alpha-numeric and numeric keys in the same array and in any order, but Javascript will make an object of it because it doesn't support arrays with keys that are alpha-numeric. When Javascript is creating an object it will also reorder the keys, it will place numeric keys before alpha-numeric keys.

This causes a problem when the JSON is sent back because the "[checksum](https://laravel-livewire.com/docs/security)" will look different.

Some types (Point, LineString, Polygon, and the Multi- variations) will also fail this checksum.

So make sure when you have a public property that is an array numeric keys are before alpha-numeric character keys.
@component('components.code', ['lang' => 'php'])
@verbatim
class HelloWorld extends Component
{
    public $list = [
        '123' => 456,
        'foo' => 'bar'
    ];
    ...
@endverbatim
@endcomponent
