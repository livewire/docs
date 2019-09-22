---
title: CSS Transitions
extends: _layouts.documentation
section: content
---

## Simple fade transition {#simple-fade}
One of the benefits of using Livewire is utilizing familiar backend functionality like Blade, while making smooth front-ends. Livewire provides a simple CSS Transition system to help achieve this effect.

Livewire provides a basic "fade" transition out-of-the-box.

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

<div>
    @if($showName)
        <div wire:transition.fade>Jerry</div>
    @endif
</div>

<?php echo $__env->renderComponent(); ?>

When `$showName` is `true`, it's contents are shown. When `$showName` becomes `false`, the contents will fade out, rather than disapear instantly.

You can control the length of this fade by adding an additional time modifier. The following directive will cause the element to fade in and out for a duration of one second.

`wire:transition.fade.1s` or `wire:transition.fade.1000ms`

<?php $__env->startComponent('_partials.warning'); ?>
If your element isn't transitioning in and out as expected, it's possible Livewire is having a hard time keeping track of it. In those cases, add a unique `key` attribute to the element like so:
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code'); ?>
<div wire:transition.fade key="unique-key">
<?php echo $__env->renderComponent(); ?>

## Simple slide transition {#simple-slide}

In addition to simple "fade" functionality. Livewire offers "slide" functionality.

<?php $__env->startComponent('_partials.code'); ?>
<div wire:transition.slide>Jerry</div>
<?php echo $__env->renderComponent(); ?>

You can customize the direction of the slide by adding extra modifiers:

<?php $__env->startComponent('_partials.code'); ?>
<div wire:transition.slide.up>Jerry</div>
<div wire:transition.slide.down>Jerry</div>
<div wire:transition.slide.left>Jerry</div>
<div wire:transition.slide.right>Jerry</div>
<?php echo $__env->renderComponent(); ?>

## Custom transitions {#custom-transitions}

Livewire provides a convenient system for performing more advanced transitions.

Let's say we want to add a "fade in and out" transition to a confirmation modal in our component. To achieve this, we need to first declare the transition in our view using Livewire's `wire:transition` directive.

<?php $__env->startComponent('_partials.code'); ?>
<div wire:transition="fade">
<?php echo $__env->renderComponent(); ?>

Now, we need to provide the appropriate CSS selectors in our app's stylesheet for this transition:

<?php $__env->startComponent('_partials.code', ['lang' => 'css']); ?>
.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
}

.fade-enter, .fade-leave {
  opacity: 0;
}
<?php echo $__env->renderComponent(); ?>

As you can see, Livewire applies the following four classes to the component at different times before adding or removing the element from the page:

Class | Description
--- | ---
.[transition]-enter | is added at the beginning of the transition-in phase, and removed one frame after
.[transition]-enter-active | is added during the entire transition-in phase
.[transition]-leave-active | is added during the entire transition-out phase
.[transition]-leave-to | is added one frame after the transition-out phase begins
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/f6a7fc78661216ffe594a599dac409ae9251555b.blade.md ENDPATH**/ ?>