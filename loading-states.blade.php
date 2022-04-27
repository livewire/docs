* [Introduction](#introduction)
* [Toggling elements during "loading" states](#toggling-elements)
* [Delaying loading indicator](#delaying-loading)
* [Targeting specific actions](#targeting-actions)
* [Targeting models](#targeting-models)
* [Toggling classes](#toggling-classes)
* [Toggling attributes](#toggling-attributes)

## Introduction {#introduction}

Because Livewire makes a roundtrip to the server every time an action is triggered on the page, there are cases when the page may not react immediately to a user event (like a click). Livewire allows you to easily display loading states, which can make your app feel more responsive.

## Toggling elements during "loading" states {#toggling-elements}

Elements with the `wire:loading` directive are only visible while waiting for actions to complete (network requests).

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout">Checkout</button>

    <div wire:loading>
        Processing Payment...
    </div>
</div>
@endcomponent

When the "Checkout" button is clicked, the "Processing Payment..." message will show. When the action is finished, the message will disappear.

By default, Livewire set's a loading element's "display" CSS property to "inline-block". If you want Livewire to use "flex" or "grid", you can use the following modifiers.

@component('components.code', ['lang' => 'blade'])
<div wire:loading.block>...</div>
<div wire:loading.flex>...</div>
<div wire:loading.inline-flex>...</div>
<div wire:loading.grid>...</div>
<div wire:loading.inline>...</div>
<div wire:loading.table>...</div>
@endcomponent

You can also "hide" an element during a loading state using the `.remove` modifier.

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout">Checkout</button>

    <div wire:loading.remove>
        Hide Me While Loading...
    </div>
</div>
@endcomponent

## Delaying loading indicator {#delaying-loading}

If you want to avoid flickering because loading is very fast, you can add the `.delay` modifier, and it will only show up if loading takes longer than `200ms`.

@component('components.code', ['lang' => 'blade'])
<div wire:loading.delay>...</div>
@endcomponent

If you wish, you can customize the delay duration with the following modifiers:

@component('components.code', ['lang' => 'blade'])
<div wire:loading.delay.shortest>...</div> <!-- 50ms -->
<div wire:loading.delay.shorter>...</div>  <!-- 100ms -->
<div wire:loading.delay.short>...</div>    <!-- 150ms -->
<div wire:loading.delay>...</div>          <!-- 200ms -->
<div wire:loading.delay.long>...</div>     <!-- 300ms -->
<div wire:loading.delay.longer>...</div>   <!-- 500ms -->
<div wire:loading.delay.longest>...</div>  <!-- 1000ms -->
@endcomponent

## Targeting specific actions {#targeting-actions}

The method outlined above works well for simple components. For more complex components, you may want to show loading indicators only for specific actions.

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout">Checkout</button>
    <button wire:click="cancel">Cancel</button>

    <div wire:loading wire:target="checkout">
        Processing Payment...
    </div>
</div>
@endcomponent

In the above example, the loading indicator will be displayed when the "Checkout" button is clicked, but not when the "Cancel" button is clicked.

`wire:target` can accept multiple arguments in a comma separated format like this: `wire:target="foo, bar"`.

You may also target actions with specific parameters.
@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="update('bob')">Update</button>

    <div wire:loading wire:target="update('bob')">
        Updating Bob...
    </div>
</div>
@endcomponent

If you wish to trigger a loading indicator when ANY of the properties of an array change, you can simply target the entire array:

@component('components.code', ['lang' => 'blade'])
<div>
    <input type="text" wire:model="post.title">
    <input type="text" wire:model="post.author">
    <input type="text" wire:model="post.content">

    <div wire:loading wire:target="post">
        Updating Post...
    </div>
</div>
@endcomponent

## Targeting models {#targeting-models}
In addition to actions, you can also target whenever a `wire:model` is synchronized.

@component('components.code', ['lang' => 'blade'])
<div>
    <input wire:model="quantity">

    <div wire:loading wire:target="quantity">
        Updating quantity...
    </div>
</div>
@endcomponent

## Toggling classes {#toggling-classes}

You can add or remove classes from an element during loading states, by adding the `.class` modifier to the `wire:loading` directive.

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout" wire:loading.class="bg-gray">
        Checkout
    </button>
</div>
@endcomponent

Now, when the "Checkout" button is clicked, the background will turn gray while the network request is processing.

You can also perform the inverse and remove classes by adding the `.remove` modifier.

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout" wire:loading.class.remove="bg-blue" class="bg-blue">
        Checkout
    </button>
</div>
@endcomponent

Now the `bg-blue` class will be removed from the button while loading.

## Toggling attributes {#toggling-attributes}

Similar to classes, HTML attributes can be added or removed from elements during loading states:

@component('components.code', ['lang' => 'blade'])
<div>
    <button wire:click="checkout" wire:loading.attr="disabled">
        Checkout
    </button>
</div>
@endcomponent

Now, when the "Checkout" button is clicked, the `disabled="true"` attribute will be added to the element while loading.
