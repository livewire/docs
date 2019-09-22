---
title: Inline Scripts
extends: _layouts.documentation
section: content
---

Although Livewire should reduce the amount of JavaScript you need to write in your applications, there are certain places where JavaScript is still very much necessary. Therefore, it is important that Livewire provides clear techniques to utilize JavaScript in your Livewire components.

The simplest way to add some JavaScript functionality to a component is in a vanilla-js inline script tag inside the component. The best way to do this is using Blade [stacks](https://laravel.com/docs/6.0/blade#stacks). This way you won't block DOM rendering in the browser, because your JavaScript will be grouped and rendered in the proper place.

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
