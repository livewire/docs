Livewire recommends that you use AlpineJS for most of your JavaScript needs, but it does support using `@verbatim@push@endverbatim` inside your component's view, to push scripts to a stack.

In your layout file, make sure to add a scripts stack after Livewire's scripts.

@component('components.code', ['lang' => 'blade'])
@verbatim
    ...
    @livewireScripts
    @stack('scripts')
</body>
</html>
@endverbatim
@endcomponent

Then in your component, you can push to your scripts stack.

@component('components.code', ['lang' => 'blade'])
@verbatim
<div>
    <!-- Your components HTML -->
</div>

@push('scripts')
    <script>
        // Your JS here.
    </script>
@endpush
@endverbatim
@endcomponent

This will also work for both Livewire and blade components that are dynamically added to the page.

@component('components.warning')
Please note that your scripts will only be pushed to the stack the first time that the component is added to the page and as such is not dynamic after that.
@endcomponent

You can also make use of the `@verbatim@once@endverbatim` directive to ensure if you have multiple of the same component on the page, that the scripts only get rendered once.

@component('components.code', ['lang' => 'blade'])
@verbatim
<div>
    <!-- Your components HTML -->
</div>

@once
    @push('scripts')
        <script>
            // Your JS here.
        </script>
    @endpush
@endonce
@endverbatim
@endcomponent

### Accessing the JavaScript component instance

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

        // Run a callback when an event ("foo") is emitted from this component
        @this.on('foo', () => {})
    })
</script>
@endverbatim
@endcomponent

> Note: the `@@this` directive compiles to the following string for JavaScript to interpret: "Livewire.find([component-id])"
