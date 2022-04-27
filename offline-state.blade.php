* [Toggling elements](#toggling-elements)
* [Toggling classes](#toggling-classes)
* [Toggling attributes](#toggling-attributes)

It's sometimes important to notify a user if they have lost their internet connection. Livewire provides helpful utilities to perform actions based on a user's "offline" state.

## Toggling elements {#toggling-elements}

You can show an element on the page when the user goes "offline", by adding the `wire:offline` attribute.

@component('components.code')
<div wire:offline>
    You are now offline.
</div>
@endcomponent

This `<div>` will automatically be hidden by default, and shown to the user when the browser goes offline.

## Toggling classes {#toggling-classes}

Adding the `class` modifier allows you to add a class to an element when "offline".

@component('components.code', ['lang' => 'blade'])
<div wire:offline.class="bg-red-300"></div>
@endcomponent

Now, when the browser goes offline, the element will receive the `bg-red-300` class. The class will be removed again once the user is back online.

You can also perform the inverse, and remove classes by adding the `.remove` modifier, similar to how `wire:loading` works.

@component('components.code', ['lang' => 'blade'])
<div wire:offline.class.remove="bg-green-300" class="bg-green-300"></div>
@endcomponent

The `bg-green-300` class will be removed from the `<div>` while offline.

## Toggling attributes {#toggling-attributes}

Adding the `attr` modifier allows you to add an attribute to an element when "offline".

@component('components.code', ['lang' => 'blade'])
<button wire:offline.attr="disabled">Submit</button>
@endcomponent

Now, when the browser goes offline, the button will be disabled.

You can also perform the inverse, and remove attributes by adding the `.remove` modifier.
