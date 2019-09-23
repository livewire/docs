---
title: Prefetching
extends: _layouts.documentation
section: content
---

Livewire offers the ability to "prefetch" the result of an action on mouseover. This is useful for cases when an action DOES NOT perform side effects, and you want a little extra performance. Toggling content is a common use case.

Add the `prefetch` modifier to an action to enable this behavior:

<?php $__env->startComponent('_partials.code'); ?>

<button wire:click.prefetch="toggleContent">Show Content</button>

@if ($contentIsVisible)
    <span>Some Content...</span>
@endif

<?php echo $__env->renderComponent(); ?>

Now, when the mouse enters the "Show Content" button, Livewire will fetch the result of the "toggleContent" action in the background. If the button is actually clicked, it will display the content on the page without sending another network request. If the button is NOT clicked, the prefetched response will be thrown away.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/7b0c3534280db71f95a627d77a9091ddee669dfd.blade.md ENDPATH**/ ?>