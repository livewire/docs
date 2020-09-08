
There are lots of instances where a page interaction doesn't warrant a full server-roundtrip, like toggling a modal.

For these cases, AlpineJS is the perfect companion to Livewire.

It allows you to sprinkle JavaScript behavior directly into your markup in a declarative/reactive way that should feel very similar to VueJS (If that's what you're used to).

## Using Alpine Inside Of Livewire {#alpine-in-livewire}

Livewire supports Alpine out of the box and works pretty hard to make the combination as smooth as possible.

> Note: You must install Alpine in order to use it. Check out [Alpine repo](https://github.com/alpinejs/alpine) for installation instructions.

Here's an example of using AlpineJS for "dropdown" functionality INSIDE a Livewire component's view.

@component('components.code', ['lang' => 'html'])
<div>
    ...

    <div x-data="{ open: false }">
        <button @click="open = true">Show More...</button>

        <ul x-show="open" @click.away="open = false">
            <li><button wire:click="archive">Archive</button></li>
            <li><button wire:click="delete">Delete</button></li>
        </ul>
    </div>
</div>
@endcomponent

## Extracting Reusable Blade Components {#extracting-blade-components}

If you are not already used to each tool on its own, mixing the syntaxes of both can be a bit confusing.

Because of this, when possible, you should extract the Alpine parts to reusable Blade components for consumption inside of Livewire (and anywhere in your app).

Here is an example (Using Laravel 7 Blade component tag syntax).

**The Livewire View:**
@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    ...

    <x-dropdown>
        <x-slot name="trigger">
            <button>Show More...</button>
        </x-slot>

        <ul>
            <li><button wire:click="archive">Archive</button></li>
            <li><button wire:click="delete">Delete</button></li>
        </ul>
    </x:dropdown>
</div>
@endverbatim
@endcomponent

**The Reusable "dropdown" Blade Component:**
@component('components.code', ['lang' => 'html'])
@verbatim
<div x-data="{ open: false }">
    <span @click="open = true">{{ $trigger }}</span>

    <div x-show="open" @click.away="open = false">
        {{ $slot }}
    </div>
</div>
@endverbatim
@endcomponent

Now, the Livewire and Alpine syntaxes are completely seperate, AND you have a reusable Blade component to use from other components.

## Interacting With Livewire From Alpine: `$wire`

From any Alpine component inside a Livewire component, you can access a magic `$wire` object to access and manipulate the Livewire component.

To demonstrate it's usage, we'll create a "counter" component in Alpine that uses Livewire completely under the hood:

@component('components.code-component')
@slot('class')
@verbatim
class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <!-- Alpine Counter Component -->
    <div x-data>
        <h1 x-text="$wire.count"></h1>

        <button x-on:click="$wire.increment()">Increment</button>
    </div>
</div>
@endverbatim
@endslot
@endcomponent

Now, when a user clicks "Increment", the standard Livewire roundtrip will trigger and Alpine will reflect Livewire's new `$count` value.

Because `$wire` uses a [JavaScript Proxy]() under the hood, you are able to access properties on it and call methods on it and those operations will be forwarded to Livewire. In addition to this functionality, `$wire` also has standard, built-in methods available to you.

Here is the full API for `$wire`:

@component('components.code', ['lang' => 'javascript'])
// Accessing a Livewire property
$wire.foo

// Calling a Livewire method
$wire.someMethod(someParam)

// Calling a Livewire method and doing something with it's result
$wire.someMethod(someParam)
    .then(result => { ... })

// Calling a Livewire method and storing it's response using async/await
let foo = await $wire.getFoo()

// Emitting a Livewire event called "some-event" with two parameters
$wire.emit('some-event', 'foo', 'bar')

// Listening for a Livewire event emitted called "some-event"
$wire.on('some-event', (foo, bar) => {})

// Getting a Livewire property
$wire.get('property')

// Setting a Livewire property to a specific value
$wire.set('property', value)

// Calling a Livewire action
$wire.call('someMethod', param)

// Accessing the underlying Livewire component JavaScript instance
$wire.__instance
@endcomponent

## Sharing State Between Livewire And Alpine: `@entangle`
Livewire has an incredibly powerful feature called "entangle" that allows you to "entangle" a Livewire and Alpine property together. With entanglement, when one value changes, the other will also be changed.

To demonstrate, consider the dropdown example from before, but now with it's `show` property entangled between Livewire and Alpine. By using entanglement, we are now able to control the state of the dropdown from both Alpine AND Livewire.

@component('components.code-component')
@slot('class')
@verbatim
class Counter extends Component
{
    public $showDropdown = false;

    public function archive()
    {
        ...
        $this->showDropdown = false;
    }

    public function delete()
    {
        ...
        $this->showDropdown = false;
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div x-data="{ open: @entangle('showDropdown') }">
    <button @click="open = true">Show More...</button>

    <ul x-show="open" @click.away="open = false">
        <li><button wire:click="archive">Archive</button></li>
        <li><button wire:click="delete">Delete</button></li>
    </ul>
</div>
@endverbatim
@endslot
@endcomponent

Now a user can toggle on the dropdown immediately with Alpine, but when they click a Livewire action like "Archive", the dropdown will be told to close from Livewire. Both Alpine and Livewire are welcome to manipulate their respective properties, and the other will automatically update.

Sometimes, it isn't necessary to update Livewire on every Alpine change, and you'd rather bundle the change with the next Livewire request that goes out. In these cases, you can chain on a `.defer` property like so:

@component('components.code', ['lang' => 'javascript'])
<div x-data="{ open: @entangle('showDropdown').defer }">
    ...
@endcomponent

Now, when a user toggles the dropdown open and closed, there will be no AJAX requests sent for Livewire, HOWEVER, when a Livewire action is triggered from a button like "archive" or "delete", the new state of "showDropdown" will be bundled along with the request.

If you are having trouble following this difference. Open your browser's devtools and observe the difference in XHR requests with and without `.defer` added.

## Accessing Livewire Directives From Blade Components
Extracting re-usable Blade components within your Livewire application is an essential pattern.

One difficulty you might encounter while implementing Blade components within a Livewire context is accessing the value of attributes like `wire:model` from inside the component.

For example, you might create a text input Blade component like so:

@component('components.code', ['lang' => 'html'])
@verbatim
<!-- Usage -->
<x-inputs.text wire:model="foo"/>

<!-- Definition -->
<div>
    <input type="text" {{ $attributes }}>
</div>
@endverbatim
@endcomponent

A simple Blade component like this will work perfectly fine. Laravel and Blade will automatically forward any extra attributes added to the component (like `wire:model` in this case), and place them on the `<input>` tag because we echod out the attribute bag (`$attributes`).

However, sometimes you might need to extract more detailed into about Livewire attributes passed to the component.

For these cases, Livewire offers a `$attributes->wire()` method to help with these tasks.

Given the following Blade Component usage:

@component('components.code', ['lang' => 'html'])
@verbatim
<x-inputs.text wire:model.defer="foo" wire:loading.class="opacity-25"/>
@endverbatim
@endcomponent

You could access Livewire directive information from Blade's `$attribute` bag like so:

@component('components.code', ['lang' => 'php'])
@verbatim
$attributes->wire('model')->value(); // "foo"
$attributes->wire('model')->modifiers(); // ["defer"]
$attributes->wire('model')->hasModifier('defer'); // true

$attributes->wire('loading')->hasModifier('class'); // true
$attributes->wire('loading')->value(); // "opacity-25"
@endverbatim
@endcomponent

You can also "forward" these Livewire directives individually. For example:

@component('components.code', ['lang' => 'html'])
@verbatim
<!-- Given -->
<x-inputs.text wire:model.defer="foo" wire:loading.class="opacity-25"/>

<!-- You could forward the "wire:model.defer="foo" directive like so: -->
<input type="text" {{ $attributes->wire('model') }}>

<!-- The output would be: -->
<input type="text" wire:model.defer="foo">
@endverbatim
@endcomponent

There are LOTS of different ways to use this utility, but one common example is using it in conjunction with the aforementioned `@entangle` directive:

@component('components.code', ['lang' => 'html'])
@verbatim
<!-- Usage -->
<x-dropdown wire:model="show">
    <x-slot name="trigger">
        <button>Show</button>
    </x-slot>

    Dropdown Contents
</x-dropdown>

<!-- Definition -->
<div x-data="{ open: @entangle($attributes->wire('model')) }">
    <span @click="open = true">{{ $trigger }}</span>

    <div x-show="open" @click.away="open = false">
        {{ $slot }}
    </div>
</div>
@endverbatim
@endcomponent

> Note: If the `.defer` modifier is passed via `wire:model.defer`, the `@entangle` directive will automatically recognize it and add the `@entangle('...').defer` modifier under the hood.

## Creating A DatePicker Component {#creating-a-datepicker}

A common use case for JavaScript inside Livewire is custom form inputs. Things like datepickers, color-pickers, etc... are often essential to your app.

By using the same pattern above, (and adding some extra sauce), we can utilize Alpine to make interacting with these types of JavaScript components a breeze.

Let's create a re-usable Blade component called `date-picker` that we can use to bind some data to in Livewire using `wire:model`.

Here's how we will be using it:

@component('components.code', ['lang' => 'html'])
@verbatim
<form wire:submit.prevent="schedule">
    <label for="title">Event Title</label>
    <input wire:model="title" id="title" type="text">

    <label for="date">Event Date</label>
    <x-date-picker wire:model="date" id="date"/>

    <button>Schedule Event</button>
</form>
@endverbatim
@endcomponent

For this component we will be using the [Pikaday](https://github.com/Pikaday/Pikaday) library.

According to the docs, the most basic usage of the package (after including the assets) looks like this:

@component('components.code', ['lang' => 'html'])
@verbatim
<input type="text" id="datepicker">

<script>
    new Pikaday({ field: document.getElementById('datepicker') })
</script>
@endverbatim
@endcomponent

All you need is an `<input>` element, and Pikaday will add all the extra date-picker behavior for you.

Now let's see how we might write a re-usable Blade component for this library.

**The `date-picker` Reusable Blade Component:**
@component('components.code', ['lang' => 'html'])
@verbatim
<input
    x-data
    x-ref="input"
    x-init="new Pikaday({ field: $refs.input })"
    type="text"
    {{ $attributes }}
>
@endverbatim
@endcomponent

> Note: The @verbatim {{ $attributes }} @endverbatim expression is a mechanism in Laravel 7 and above to forward extra HTML attributes declared on the component tag.

## Forwarding `wire:model` `input` Events

Under the hood, `wire:model` adds an event listener to update a property every time the `input` event is dispatched on or under the element. Another way to communicate between Livewire and Alpine is by using Alpine to dispatch an `input` event with some data within or on an element with `wire:model` on it.

Let's create a contrived example where when a user clicks a one button a property called `$foo` is set to `bar`, and when a user clicks another button, `$foo` is set to `baz`.

**Within A Livewire Component's View:**
@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    <div wire:model="foo">
        <button x-data @click="$dispatch('input', 'bar')">Set to "bar"</button>
        <button x-data @click="$dispatch('input', 'baz')">Set to "baz"</button>
    </div>
</div>
@endverbatim
@endcomponent

A more real-world example would be creating a "color-picker" Blade component that might be consumed inside a Livewire component.

**Color-picker Component Usage:**
@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    <x-color-picker wire:model="color"/>
</div>
@endverbatim
@endcomponent

For the component definition, we will be using a third-party color-picker lib called [Vanilla Picker](https://vanilla-picker.js.org/).

This sample assumes you have it loaded on the page.

**Color-picker Blade Component Definition (Un-commented):**
@component('components.code', ['lang' => 'html'])
@verbatim
<div
    x-data="{ color: '#ffffff' }"
    x-init="
        picker = new Picker($refs.button);
        picker.onDone = rawColor => {
            color = rawColor.hex;
            $dispatch('input', color)
        }
    "
    wire:ignore
    {{ $attributes }}
>
    <span x-text="color" :style="`background: ${color}`"></span>
    <button x-ref="button">Change</button>
</div>
@endverbatim
@endcomponent

**Color-picker Blade Component Definition (Commented):**
@component('components.code', ['lang' => 'html'])
@verbatim
<div
    x-data="{ color: '#ffffff' }"
    x-init="
        // Wire up to show the picker when clicking the 'Change' button.
        picker = new Picker($refs.button);
        // Run this callback every time a new color is picked.
        picker.onDone = rawColor => {
            // Set the Alpine 'color' property.
            color = rawColor.hex;
            // Dispatch the color property for 'wire:model' to pick up.
            $dispatch('input', color)
        }
    "
    // Vanilla Picker will attach its own DOM inside this element, so we need to
    // add `wire:ignore` to tell Livewire to skip DOM-diffing for it.
    wire:ignore
    // Forward the any attributes added to the component tag like `wire:model=color`
    {{ $attributes }}
>
    <!-- Show the current color value with the backgound color set to the chosen color. -->
    <span x-text="color" :style="`background: ${color}`"></span>
    <!-- When this button is clicked, the color-picker dialogue is shown. -->
    <button x-ref="button">Change</button>
</div>
@endverbatim
@endcomponent

## Ignoring DOM-changes (using `wire:ignore`)

Fortunately a library like Pikaday adds its extra DOM at the end of the page. Many other libraries manipulate the DOM as soon as they are initialized and continue to mutate the DOM as you interact with them.

When this happens, it's hard for Livewire to keep track of what DOM manipulations you want to preserve on component updates, and which you want to discard.

To tell Livewire to ignore changes to a subset of HTML within your component, you can add the `wire:ignore` directive.

The Select2 library is one of those libraries that takes over its portion of the DOM (it replaces your `<select>` tag with lots of custom markup).

Here is an example of using the Select2 library inside a Livewire component to demonstrate the usage of `wire:ignore`.

@component('components.code', ['lineHighlight' => '2'])
@verbatim
<div>
    <div wire:ignore>
        <select class="select2" name="state">
            <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option>
        </select>

        <!-- Select2 will insert its DOM here. -->
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
@endverbatim
@endcomponent

@component('components.tip')
Also, note that sometimes it's useful to ignore changes to an element, but not its children. If this is the case, you can add the <code>self</code> modifier to the <code>wire:ignore</code> directive, like so: <code>wire:ignore.self</code>.
@endcomponent
