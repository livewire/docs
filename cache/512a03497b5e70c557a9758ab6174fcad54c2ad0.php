---
title: Data Binding
extends: _layouts.documentation
section: content
---

If you've used front-end frameworks like Angular, React, or Vue, you are already familiar with this concept. However, if you are new to this concept, allow me to demonstrate.

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'MyNameIs',
    'viewName' => 'my-name-is.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

use Livewire\Component;

class MyNameIs extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    <input type="text" wire:model="name">

    Hi! My name is {{ $name }}
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

When the user types something into the text field, the value of the `$name` property will automatically update. Livewire knows to keep track of the provided name because of the `wire:model` directive.

Internally, Livewire listens for "input" events on the element and updates the class property with the element's value. Therefore, you can apply `wire:model` to any element that emits `input` events.

<?php $__env->startComponent('_partials.tip'); ?>
By default, Livewire applies a 150ms debounce to text inputs. You can override this default like so: <code>&lt;input type="text" wire:model.debounce.0ms="name"&gt;</code>
<?php echo $__env->renderComponent(); ?>

Common elements to use `wire:model` on include:

Element Tag |
--- |
`<input type="text">` |
`<input type="radio">` |
`<input type="checkbox">` |
`<select>` |
`<textarea>` |

## Nested Data Binding {#nested-binding}

Livewire supports nested data binding using dot notation:

<?php $__env->startComponent('_partials.code'); ?>
<input type="text" wire:model="form.name">
<?php echo $__env->renderComponent(); ?>

## Debouncing Input {#debouncing}

Livewire offers a "debounce" modifier when using `wire:model`. If you want to apply a 1 second debounce to an input, you include the modifier like so:

<?php $__env->startComponent('_partials.code'); ?>
<input type="text" wire:model.debounce.1000ms="name">

<!-- You can also specify the time in seconds: -->
<input type="text" wire:model.debounce.1s="name">
<?php echo $__env->renderComponent(); ?>

## Lazily Updating {#lazilly-updating}

By default, Livewire sends a request to server after every "input" event. This is usually fine for things like `<select>` elements that don't update frequently, however, this is often unnecessary for text fields that update as the user types.

In those cases, use the `lazy` directive modifier to listen for the native "change" event.

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'MyNameIs',
    'viewName' => 'my-name-is.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

use Livewire\Component;

class MyNameIs extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.my-name-is');
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    <input type="text" wire:model.lazy="name">

    My name is chica-chica {{ $name }}
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

Now, the `$name` property will only be updated when the user clicks away from the input field.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/8d335d8e9a462784096d19fdefc83849c0cb3015.blade.md ENDPATH**/ ?>