
Livewire makes it extremely easy to use Vue components inside your Livewire components, and it even goes a step further and interfaces with them directly!

Let's say we have a `<loading-spinner>` Vue component, and we want to use it in our Livewire component.

@component('components.code')
<div>
    <button wire:click="checkout">Checkout</button>

    <loading-spinner wire:loading></loading-spinner>
</div>
@endcomponent

That's it!

@component('components.warning')
In order to use Livewire with Vue a <code>window.Vue</code> object must be made available to Livewire.
@endcomponent

### Binding data to Vue components {#binding-to-vue-components}
We can even take this integration a step further and actually bind Livewire properties to Vue components.

Let's assume we have a custom Vue component that we typically use for "taggable" input fields called `<input-taggable></input-taggable>`. Normally, inside Vue, you would bind data to this component like so:

@component('components.code')
<input-taggable v-model="names"></input-taggable>
@endcomponent

Alternatively, it is possible to instead bind Livewire properties to custom Vue components like so:

@component('components.code')
<input-taggable wire:model="names"></input-taggable>
@endcomponent

Livewire will listen for "input" events emitted from the Vue component, and pass down "value" properties just like Vue does. It just works.
