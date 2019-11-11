---
title: Third-Party Libraries
extends: _layouts.documentation
section: content
---

It's common to use third-party JavaScript libraries for small UI components like date-pickers and wysiwyg text editors.

It is outside the scope of this documentation to provide info for specific libraries; however, the techniques for adapting Livewire to other libraries are generally similar. Therefore, we'll just use one common example as a teaching point:

## Select2 {#select2}

Let's say you are using a package like [Select2](https://select2.org) in your component's template to sync a data property called `$foo`. You might think it's as simple as the following:

@code
@verbatim
<div>
    <select wire:model="foo" class="js-example-basic-single" name="state">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
    </select>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endpush
@endverbatim
@endcode

On first load, everything will appear normal as if it's all working, but you'll notice, when you select an item drom the dropdown, the `$foo` property won't be updated.

This is because Select2 is a jQuery plugin and emits jQuery events, and not native DOM events. Livewire normally listens for a native `change` event when `wire:model` is attached to an element.

To get around this, we can register a listener manually (and remove the `wire:model`) in the script tag like so:

@code(['lineHighlight' => '12-14'])
@verbatim
<div>
    <select class="js-example-basic-single" name="state">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
    </select>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('change', function (e) {
            @this.set('foo', e.target.value);
        });
    });
</script>
@endpush
@endverbatim
@endcode

This will tell Livewire to update the `$foo` property everytime the Select2 element's value changes.

Now, you'll notice when you change the element, it updates the value, but the Select2 element is destroyed and replaced with an un-reactive native `<select>` element.

When you initialize a `<select>` element with Select2, Select2 will hijack the element and add it's own dom as a sibling.

Now that we've triggered a Livewire update, Livewire will get HTML back from the server, compare it to the Select2 DOM manipulations on the page, see the difference, and remove all the changes Select2 made.

To get around this, we must tell Livewire to ignore DOM changes made by the library.

### Ignoring DOM-changes (using `wire:ignore`)

We can tell Livewire to skip the DOM-diffing for certain parts of the DOM with the `wire:ignore` directive. Here is a working implementation of Select2:

@code(['lineHighlight' => '2'])
@verbatim
<div>
    <div wire:ignore>
        <select class="js-example-basic-single" name="state">
            <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option>
        </select>

        <!-- Select2 will insert it's DOM here. -->
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('change', function (e) {
            @this.set('foo', e.target.value);
        });
    });
</script>
@endpush
@endverbatim
@endcode

@tip
Also, note that sometimes it's useful to ignore changes to an element, but not it's children. If this is the case, you can add the <code>self</code> modifier to the <code>wire:ignore</code> directive, like so: <code>wire:ignore.self</code>.
@endtip
