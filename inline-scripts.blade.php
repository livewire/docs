* [Introduction](#introduction)
* [Using the `@verbatim@js@endverbatim` directive](#using-js-directive)
* [Accessing the JavaScript component instance](#accessing-javascript-component-instance)

## Introduction {#introduction}

Livewire recommends that you use AlpineJS for most of your JavaScript needs, but it does support using `<script>` tags directly inside your component's view.

@component('components.code', ['lang' => 'blade'])
@verbatim
<div>
    <!-- Your components HTML -->

    <script>
        document.addEventListener('livewire:load', function () {
            // Your JS here.
        })
    </script>
</div>
@endverbatim
@endcomponent

@component('components.warning')
Please note that your scripts will be run only once upon the first render of the component. If you need to run a JavaScript function later - emit the event from the component and listen to it in JavaScript as described <a href="https://laravel-livewire.com/docs/events/">here</a>)
@endcomponent

You can also push scripts directly onto Blade stacks from your Livewire component:

@component('components.code', ['lang' => 'javascript'])
@verbatim
<!-- Your component's view here -->

@push('scripts')
<script>
    // Your JS here.
</script>
@endpush
@endverbatim
@endcomponent

## Using the `@verbatim@js@endverbatim` directive {#using-js-directive}

If ever you need to output PHP data for use in Javascript, you can now use the `@verbatim@js@endverbatim` directive.

@component('components.code', ['lang' => 'blade'])
@verbatim
<script>
    let posts = @js($posts)
    
    // "posts" will now be a JavaScript array of post data from PHP.
</script>
@endverbatim
@endcomponent

## Accessing the JavaScript component instance {#accessing-javascript-component-instance}

Because Livewire has both a PHP AND a JavaScript portion, each component also has a JavaScript object. You can access this object using the special `@@this` blade directive in your component's view.

Here's an example:

@component('components.code', ['lang' => 'javascript'])
@verbatim
<script>
    document.addEventListener('livewire:load', function () {
        // Get the value of the "count" property
        var someValue = @this.count

        // Set the value of the "count" property
        @this.count = 5

        // Call the increment component action
        @this.increment()

        // Run a callback when an event ("foo")
        // is emitted from this component
        @this.on('foo', () => {})
    })
</script>
@endverbatim
@endcomponent

> Note: the `@@this` directive compiles to the following string for JavaScript to interpret: "Livewire.find([component-id])"
