---
title: Dirty States
extends: _layouts.documentation
section: content
---

There are cases where it may be useful to provide feedback that content has changed and is not yet in-sync with the back-end Livewire component.

For input that uses `wire:model`, or `wire:model.lazy`, you may want to display that a field is 'dirty' until Livewire has fully updated.

## Toggling classes on "dirty" elements {#toggling-classes}

Elements with the `wire:dirty` directive will watch for differences between the front-end value, and the last returned Livewire data value.

Adding the `class` modifier allows you to add a class to the element when dirty.

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div>
    <input wire:dirty.class="border-red-500" wire:model.lazy="foo">
</div>
<?php echo $__env->renderComponent(); ?>

Now, when a user modifies the input value, the element will receive the `border-red-500` class. The class will be removed again if the input value returns to its original state, or if the Livewire component updates.

You can also perform the inverse, and remove classes by adding the `.remove` modifier, similar to how `wire:loading` works.

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div>
    <input wire:dirty.class.remove="bg-green-200" class="bg-green-200" wire:model.lazy="foo">
</div>
<?php echo $__env->renderComponent(); ?>

The `bg-green-200` class will be removed from the input while dirty.

## Toggling elements {#toggling-elements}

The default behaviour of the `wire:dirty` directive without modifiers is that the element will be hidden until dirty. This can create a paradox if used on the input itself, but like loading states, the `dirty` directive can be used to toggle the appearance of other elements using `wire:ref` and `wire:target`

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div>
    <span wire:dirty wire:target="foo-input">Updating...</span>
    <input wire:model.lazy="foo" wire:ref="foo-input">
</div>
<?php echo $__env->renderComponent(); ?>

In this example, the `span` will be hidden by default, and only visible when the input element is dirty.

## Toggling classes on other elements {#toggling-classes}

The class and atribute modifiers can be used in the same way for referenced elements

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div>
    <label wire:dirty.class="text-red-500" wire:target="foo-input">Full Name</label>
    <input wire:model.lazy="foo" wire:ref="foo-input">
</div>
<?php echo $__env->renderComponent(); ?>

Now, when the `foo-input` is dirty, the label text will receive the `text-red-500` class.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/85874290c04d4637618ee6155394a638ed660f02.blade.md ENDPATH**/ ?>