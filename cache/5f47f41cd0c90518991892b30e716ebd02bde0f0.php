---
title: Polling
extends: _layouts.documentation
section: content
---

Livewire offers a directive called `wire:poll` that, when added to an element, will refresh the component every `5s`.

<?php $__env->startComponent('_partials.tip'); ?>
Polling for changes over Ajax is a lightweight, simpler alternative to something like Laravel Echo, Pusher, or any WebSocket strategy.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code'); ?>

<div wire:poll>
    Current time: {{ now() }}
</div>

<?php echo $__env->renderComponent(); ?>

You can customize the frequency by passing a directive modifier like `750ms`. For example:

<?php $__env->startComponent('_partials.code'); ?>

<div wire:poll.750ms>
    Current time: {{ now() }}
</div>

<?php echo $__env->renderComponent(); ?>

You can also specify a specific action to fire on the polling interval by passing a value to `wire:poll`:

<?php $__env->startComponent('_partials.code'); ?>

<div wire:poll="foo">
    Current time: {{ now() }}
</div>

<?php echo $__env->renderComponent(); ?>

Now, the `foo` method on the component will be called every 5 seconds.

<?php $__env->startComponent('_partials.tip'); ?>
Livewire stops polling when the browser tab is in the background so that it doesn't bog down the server with ajax requests unnecessarily.
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/fc2e8c1c095d65d7df461a7a77f0c83f168f6555.blade.md ENDPATH**/ ?>