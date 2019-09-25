---
title: Offline State
extends: _layouts.documentation
section: content
---

It's sometimes important to notify a user if they have lost their internet connection. Livewire provides helpful utilities to perform actions based on a user's "offline" state.

## Toggling elements {#toggling-elements}

You can show an element on the page when the user goes "offline", by adding the `wire:offline` attribute.

<?php $__env->startComponent('_partials.code'); ?>
<div wire:offline>
    You are now offline.
</div>
<?php echo $__env->renderComponent(); ?>

This `<div>` will automatically be hidden by default, and shown to the user when the browser goes offline.

## Toggling classes {#toggling-classes}

Adding the `class` modifier allows you to add a class to an element when "offline".

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div wire:offline.class="bg-red-300"></div>
<?php echo $__env->renderComponent(); ?>

Now, when the browser goes offline, the element will receive the `bg-red-300` class. The class will be removed again once the user is back online.

You can also perform the inverse, and remove classes by adding the `.remove` modifier, similar to how `wire:loading` works.

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<div wire:offline.class.remove="bg-green-300" class="bg-green-300"></div>
<?php echo $__env->renderComponent(); ?>

The `bg-green-300` class will be removed from the `<div>` while offline.

## Toggling attributes {#toggling-attributes}

Adding the `attr` modifier allows you to add an attribute to an element when "offline".

<?php $__env->startComponent('_partials.code', ['lang' => 'html']); ?>
<button wire:offline.attr="disabled">Submit</button>
<?php echo $__env->renderComponent(); ?>

Now, when the browser goes offline, the button will be disabled.

You can also perform the inverse, and remove attributes by adding the `.remove` modifier.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/93ffaf10a4a0309ccfa1eef169600c6a2f202960.blade.md ENDPATH**/ ?>