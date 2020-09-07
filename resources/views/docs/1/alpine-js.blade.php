
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

    <x:dropdown>
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
    <x:date-picker wire:model="date" id="date"/>

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
    <x:color-picker wire:model="color"/>
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

## Communicating Between Livewire and JavaScript {#communicating-with-js}

Every Livewire component loaded on a browser page has both a unique id, and a corresponding JavaScript object.

You can retrieve this JavaScript object with the following syntax:
`let component = window.livewire.find('some-component-id')`

Now that you have the component object, you can actually interact with it programaticaly from JavaScript.

For example, given the following Livewire component:

@component('components.code-component', [
    'className' => 'CreatePost',
    'viewName' => 'create-post.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class CreatePost extends Component
{
    public $title = '';

    public function create()
    {
        Post::create(['title' => $this->title]);
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="create">
    <input wire:model="title" type="text">

    <button>Create Post</button>
</form>
@endverbatim
@endslot
@endcomponent

If you happened to know the unique component ID assigned to this component when it was loaded in the browser, you could run the following in the DevTools (or from any JavaScript on the page):

@component('components.code', ['lang' => 'javascript'])
@verbatim
<script>
    let component = window.livewire.find('the-unique-component-id')

    var title = component.get('title')
    // Gets the current value of the `public $title` component property.
    // Which defaults to '', so `title` would be set to an
    // empty string initially.

    component.set('title', 'Some Title')
    // Sets the `public $title` component property to "Some Title"
    // You will actually see "Some Title" fill the input field
    // on the page. To Livewire there is no difference between
    // Calling this method and actually typing into the input field.

    component.call('create')
    // This will call the "create" method on the component
    // exactly as if you physically clicked the create
    // button inside the form.
</script>
@endverbatim
@endcomponent

If you can follow, you should be able to see the potential here. This API allows you to interact with a Livewire component, programatically, from JavaScript. This pattern unlocks all sorts of potential.

You may be wondering, "But how do I get the unique component id?". Well, you can inspect the source and look at the `wire:id` attribute on the root element of the component. OR you can use this very handy syntax from inside your Livewire component's view:

@component('components.code', ['lang' => 'javascript'])
@verbatim
<div>
    <input x-data @input.keydown.enter="@this.set('foo', 'bar')">
</div>
@endverbatim
@endcomponent

If you followed, Livewire has a Blade directive called `@this` that is an alias for `window.livewire.find('...')`. This directive makes it extremely easy to talk to the current Livewire component from JavaScript, particularly AlpineJS expressions.

If you were to inspect the source of the rendered page in the browser, here is what that `input` element would look like:

@component('components.code', ['lang' => 'javascript'])
@verbatim
<input x-data @input.keydown.enter="window.livewire.find('unique-id').set('foo', 'bar')">
@endverbatim
@endcomponent

As you can see the Livewire & Alpine combo can be extremely powerful and expressive.
