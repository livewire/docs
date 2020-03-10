
## Simple fade transition {#simple-fade}
One of the benefits of using Livewire is utilizing familiar backend functionality like Blade, while making smooth front-ends. Livewire provides a simple CSS Transition system to help achieve this effect.

Livewire provides a basic "fade" transition out-of-the-box.

@component('components.code', ['lang' => 'php'])
@verbatim
<div>
    @if($showName)
        <div wire:transition.fade>Jerry</div>
    @endif
</div>
@endverbatim
@endcomponent

When `$showName` is `true`, it's contents are shown. When `$showName` becomes `false`, the contents will fade out, rather than disapear instantly.

You can control the length of this fade by adding an additional time modifier. The following directive will cause the element to fade in and out for a duration of one second.

`wire:transition.fade.1s` or `wire:transition.fade.1000ms`

@component('components.warning')
If your element isn't transitioning in and out as expected, it's possible Livewire is having a hard time keeping track of it. In those cases, add a unique `wire:key` attribute to the element like so:
@endcomponent

@component('components.code')
<div wire:transition.fade wire:key="unique-key">
@endcomponent

## Simple slide transition {#simple-slide}

In addition to simple "fade" functionality, Livewire offers "slide" functionality.

@component('components.code')
<div wire:transition.slide>Jerry</div>
@endcomponent

You can customize the direction of the slide by adding extra modifiers:

@component('components.code')
<div wire:transition.slide.up>Jerry</div>
<div wire:transition.slide.down>Jerry</div>
<div wire:transition.slide.left>Jerry</div>
<div wire:transition.slide.right>Jerry</div>
@endcomponent

## Custom transitions {#custom-transitions}

Livewire provides a convenient system for performing more advanced transitions.

Let's say we want to add a "fade in and out" transition to a confirmation modal in our component. To achieve this, we need to first declare the transition in our view using Livewire's `wire:transition` directive.

@component('components.code')
<div wire:transition="fade">
@endcomponent

Now, we need to provide the appropriate CSS selectors in our app's stylesheet for this transition:

@component('components.code', ['lang' => 'css'])
.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
}

.fade-enter, .fade-leave {
  opacity: 0;
}
@endcomponent

As you can see, Livewire applies the following four classes to the component at different times before adding or removing the element from the page:

@component('components.table')
Class | Description
--- | ---
.[transition]-enter | is added at the beginning of the transition-in phase, and removed one frame after
.[transition]-enter-active | is added during the entire transition-in phase
.[transition]-leave-active | is added during the entire transition-out phase
.[transition]-leave-to | is added one frame after the transition-out phase begins
@endcomponent
