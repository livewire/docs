---
title: Nesting Components
extends: _layouts.documentation
section: content
---

Livewire supports nesting components. This feature, allows you to compose components from other components, which is an incredibly powerful architectural pattern.

Here is an example of a nested component:

<?php $__env->startComponent('_partials.code-component', [
    'viewName' => 'show-users.blade.php',
]); ?>
<?php $__env->slot('view'); ?>

<div>
    @livewire('user-profile', $user)
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.warning'); ?>
A common misconception is that properties passed into Livewire components is "reactive" (like Vue or React). Because of the way Livewire architects components, this is impossible. The data you pass into a nested component is set initially and not updated if the parent changes. For all component interactions, refer to the <a href="/docs/events">Events page.</a>
<?php echo $__env->renderComponent(); ?>

## Keyed Components {#keyed-components}

Similar to VueJs, if you render a component inside a loop, Livewire has trouble keeping track of changes made to those components. To remedy this, livewire offers a special "key" syntax:

<?php $__env->startComponent('_partials.code-component', [
    'viewName' => 'show-users.blade.php',
]); ?>
<?php $__env->slot('view'); ?>

<div>
    @foreach ($users as $user)
        @livewire('user-profile', $user, key($user->id))
    @endforeach
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

> Note: Livewire doesn't actually call PHP's "key()" function, it just uses "key()" as a signifier in it's blade parser.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/41e8ad67515a065de4e8b164ef42241faaae78bd.blade.md ENDPATH**/ ?>