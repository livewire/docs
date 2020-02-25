---
title: Prefetching
extends: _layouts.documentation
section: content
---

Livewire offers the ability to "prefetch" the result of an action on mouseover. Toggling display content is a common use case.

@warning
This is useful for cases when an action DOES NOT (like writing to session or database) perform side effects. If the action you are "pre-fetching" has side-effects, the side-effects will be unpredictably executed.
@endwarning

Add the `prefetch` modifier to an action to enable this behavior:

@code
@verbatim
<button wire:click.prefetch="toggleContent">Show Content</button>

@if ($contentIsVisible)
    <span>Some Content...</span>
@endif
@endverbatim
@endcode

Now, when the mouse enters the "Show Content" button, Livewire will fetch the result of the "toggleContent" action in the background. If the button is actually clicked, it will display the content on the page without sending another network request. If the button is NOT clicked, the prefetched response will be thrown away.
