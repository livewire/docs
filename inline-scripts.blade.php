Livewire recommends that you use AlpineJS for most of your JavaScript needs, but it does support using `<script>` tags directly inside your component's view.

@component('components.code', ['lang' => 'html'])
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
        
        // Is also possible set a value with defer. The third parameter apply defer directive
        @this.set('count', 5, true);
        
        // Call the increment component action
        @this.increment()

        // Run a callback when an event ("foo") is emitted from this component
        @this.on('foo', () => {})
    })
</script>
@endverbatim
@endcomponent

> Note: the `@@this` directive compiles to the following string for JavaScript to interpret: "Livewire.find([component-id])"
