---
title: Custom JavaScript
extends: _layouts.documentation
section: content
---

Although Livewire should reduce the amount of JavaScript you need to write in your applications, there are certain places where JavaScript is still very much necessary. Therefore, it is important that Livewire plays nice with modern JavaScript tools like Vue out-of-the-box.

## Vanilla JavaScript {#vanilla-javascript}

The best way to write JavaScript in a livewire component, is using Blade [stacks](https://laravel.com/docs/6.0/blade#stacks). This way you won't block DOM rendering in the browser, because your JavaScript will be grouped and rendered in the proper place.

### Setting up a "scripts" stack {#scripts-stack}

Declare a `@@stack('scripts')` inside your Blade layout file.

@code
@verbatim
...
    @livewireAssets
    @stack('scripts')
</head>
@endverbatim
@endcode

### Pushing to the scripts stack {#push-to-scripts-stack}

Now, from your component's Blade view, you can push to the `scripts` stack:

@code
@verbatim
<div>
    <!-- Your components HTML -->
</div>

@push('scripts')
<script type="text/javascript">
    // Your JS here.
</script>
@endpush
@endverbatim
@endcode

### Accessing the JavaScript component instance

Because Livewire has both a PHP AND a JavaScript portion, each component also has a JavaScript object. You can access this object using the special `@@this` blade directive in your component's view.

Here's an example:

@code(['lang' => 'javascript'])
@verbatim
...

@push('scripts')
<script type="text/javascript">
    // Get the value of the "count" property
    var someValue = @this.get('count')

    // Set the value of the "count" property
    @this.set('count', 5)

    // Call the increment component action
    @this.call('increment')
</script>
@endpush
@endverbatim
@endcode

> Note: the `@@this` directive compiles to the following string for JavaScript to interpret: "window.livewire.find([component-id])"

## VueJs {#vue}

Livewire makes it extremely easy to use Vue components inside your Livewire components, and it even goes a step further and interfaces with them directly!

Let's say we have a `<loading-spinner>` Vue component, and we want to use it in our Livewire component.

@code
<div>
    <button wire:click="checkout">Checkout</button>

    <loading-spinner wire:loading></loading-spinner>
</div>
@endcode

That's it!

@warning
In order to use Livewire with Vue a <code>window.Vue</code> object must be made available to Livewire.
@endwarning

### Binding data to Vue components {#binding-to-vue-components}
We can even take this integration a step further and actually bind Livewire properties to Vue components.

Let's assume we have a custom Vue component that we typically use for "taggable" input fields called `<input-taggable></input-taggable>`. Normally, inside Vue, you would bind data to this component like so:

@code
<input-taggable v-model="names"></input-taggable>
@endcode

Alternatively, it is possible to instead bind Livewire properties to custom Vue components like so:

@code
<input-taggable wire:model="names"></input-taggable>
@endcode

Livewire will listen for "input" events emitted from the Vue component, and pass down "value" properties just like Vue does. It just works.

## Web Components {#web-components}
Another great way to utilize JavaScript inside Livewire components is HTML5 Web Components. This strategy is preffered to most others because Web Components automatically scope JS and styles to each individual component, so there are no conflicts with Livewire.

Building and using Web Components is outside the scope of this documentation, but the [lit-element](https://lit-element.polymer-project.org/guide) project is a great starting point for writing and using web components easily.
