---
title: Data Binding
description: todo
extends: _layouts.documentation
section: content
---

If you've used front-end frameworks like Angular, React, or Vue, you are already familiar with this concept. However, if you are new to this concept, allow me to demonstrate.

<div title="Component"><div title="Component__class">

MyNameIs
```php
class MyNameIs extends LivewireComponent
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}
```
</div>
<div title="Component__view">

my-name-is.blade.php
```html
<div>
    <input type="text" wire:model="name">

    My name is chica-chica <?php echo e($name); ?>

</div>
```
</div>
</div>

When the user types "Slim Shady" into the text field, the value of the `$name` property will automatically update. Livewire knows to keep track of the provided name because of the `wire:model` directive.

Internally, Livewire listens for "input" events on the element and updates the class property with the element's value. Therefore, you can apply `wire:model` to any element that emits `input` events.

Common elements to use `wire:model` on include:

Element Tag |
--- |
`<input type="input">` |
`<input type="radio">` |
`<input type="checkbox">` |
`<select>` |
`<textarea>` |

## Lazily Updating

By default, Livewire sends a request to server after every "input" event. This is usually fine for things like `<select>` elements that don't update frequently, however, this is often unnescessary for text fields that update as the user types.

In those cases, use the `lazy` directive modifier to listen for the native "change" event.

<div title="Component"><div title="Component__class">

MyNameIs
```php
class MyNameIs extends LivewireComponent
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}
```
</div>
<div title="Component__view">

my-name-is.blade.php
```html
<div>
    <input type="text" wire:model.lazy="name">

    My name is chica-chica <?php echo e($name); ?>

</div>
```
</div>
</div>

Now, the `$todo` property will only be updated when the user clicks away from the input field.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/bab7da917932dd8166982f1bc97c104d980bcf30.blade.md ENDPATH**/ ?>