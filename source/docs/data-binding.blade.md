---
title: Data Binding
description: todo
extends: _layouts.documentation
section: content
---

# Data Binding

If you've used front-end frameworks like Angular, React, or Vue, you are already familiar with this concept. However, if you are new to this concept, allow me to demonstrate.

@codeComponent([
    'className' => 'MyNameIs',
    'viewName' => 'my-name-is.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class MyNameIs extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <input type="text" wire:model="name">

    Hi! My name is {{ $name }}
</div>
@endverbatim
@endslot
@endcodeComponent

When the user types something into the text field, the value of the `$name` property will automatically update. Livewire knows to keep track of the provided name because of the `wire:model` directive.

Internally, Livewire listens for "input" events on the element and updates the class property with the element's value. Therefore, you can apply `wire:model` to any element that emits `input` events.

`<input type="text">`
@tip
By default, Livewire applies a 150ms debounce to text inputs. You can override this default like so: <code>&lt;input type="text" wire:model.debounce.0ms="name"&gt;</code>
@endtip

Common elements to use `wire:model` on include:

Element Tag |
--- |
`<input type="input">` |
`<input type="radio">` |
`<input type="checkbox">` |
`<select>` |
`<textarea>` |

## Debouncing Input

Livewire offers a "debounce" modifier when using `wire:model`. If you want to apply a 1 second debounce to an input, you include the modifier like so:

@code
<input type="text" wire:model.debounce.1000ms="name">

<!-- You can also specify the time in seconds: -->
<input type="text" wire:model.debounce.1s="name">
@endcode

## Lazily Updating

By default, Livewire sends a request to server after every "input" event. This is usually fine for things like `<select>` elements that don't update frequently, however, this is often unnecessary for text fields that update as the user types.

In those cases, use the `lazy` directive modifier to listen for the native "change" event.


@codeComponent([
    'className' => 'MyNameIs',
    'viewName' => 'my-name-is.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class MyNameIs extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <input type="text" wire:model.lazy="name">

    My name is chica-chica {{ $name }}
</div>
@endverbatim
@endslot
@endcodeComponent

Now, the `$name` property will only be updated when the user clicks away from the input field.
