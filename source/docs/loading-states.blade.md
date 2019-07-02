---
title: Loading States
description: todo
extends: _layouts.documentation
section: content
---

# Loading States

Because Livewire makes a roundtrip to the server every time an action is triggered on the page, there are cases where the page may not react immediately to a user event (like a click). It is up to you to determine when you should provide the user with some kind of loading state or not.

## Toggling elements during "loading" states

Elements with the `wire:loading` directive are only visible while waiting for actions to complete (network requests).

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout">Checkout</button>

    <div wire:loading>
        Processing Payment...
    </div>
</div>
@endcode

If you don't want to add the global style from above, you can declare `display: none` as an inline style like so:

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout">Checkout</button>

    <div wire:loading style="display: none">
        Processing Payment...
    </div>
</div>
@endcode

When the "Checkout" button is clicked, the "Processing Payment..." message will show. When the action is finished, the message will disapear.

## Targeting specific actions
The method outlined above works great for simple components, however, it's common to want to only show loading indicators for specific actions. Consider the following example:

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout">Checkout</button>
    <button wire:click="cancel">Cancel</button>

    <div wire:loading>
        Processing Payment...
    </div>
</div>
@endcode

Notice, we've added a "Cancel" button to the checkout form. If the user clicks the "Cancel" button, the "Processing Payment..." message will show briefly. This is clearly undesirable, therefore Livewire offers two directives. You can add `wire:target` to the loading indicator, and pass in the name of a `ref` you define by attaching `wire:ref` to the target. Let's look at the adapted example:

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout" wire:ref="checkout-button">Checkout</button>
    <button wire:click="cancel">Cancel</button>

    <div wire:loading wire:target="checkout-button">
        Processing Payment...
    </div>
</div>
@endcode

Now, when the "Checkout" button is clicked, the loading indicator will load, but not when the "Cancel" button is clicked.

## Toggling classes

You can add or remove classes from an element during loading states, but adding the `.class` modifier to the `wire:loading` directive.

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout" wire:loading.class="bg-gray">
        Checkout
    </button>
</div>
@endcode

Now, when the "Checkout" button is clicked, the background will turn gray while the network request is processing.

You can also perform the inverse and remove classes by adding the `.remove` modifier.

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout" wire:loading.class.remove="bg-blue" class="bg-blue">
        Checkout
    </button>
</div>
@endcode

Now the `bg-blue` class will be removed from the button while loading.

## Toggling attributes

Similar to classes, HTML attributes can be added or removed from elements during loading states:

@code(['lang' => 'html'])
<div>
    <button wire:click="checkout" wire:loading.attr="disabled">
        Checkout
    </button>
</div>
@endcode

Now, when the "Checkout" button is clicked, the `disabled="true"` attribute will be added to the element while loading.
