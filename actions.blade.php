* [Introduction](#introduction) { .text-blue-800 }
* [Passing Action Parameters](#action-parameters) { .text-blue-800 }
* [Event Modifiers](#event-modifiers) { .text-blue-800 }
  * [Keydown Modifiers](#keydown-modifiers) { .font-normal.text-sm.text-blue-800 }
* [Magic Actions](#magic-actions) { .text-blue-800 }

<div>&nbsp;</div>

@include('includes.screencast-cta')

## Introduction {#introduction}

The goal of actions in Livewire is to be able to easily listen to page interactions, and call a method on your Livewire component (re-rendering the component).

Here's the basic usage:

@component('components.code-component')
@slot('class')
class ShowPost extends Component
{
    public Post $post;

    public function like()
    {
        $this->post->addLikeBy(auth()->user());
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <button wire:click="like">Like Post</button>
</div>
@endverbatim
@endslot
@endcomponent

Livewire currently offers a handful of directives to make listening to browser events trivial. The common format for all of them is: `wire:[dispatched browser event]="[action]"`.

Here are some common events you may need to listen for:

@component('components.table')
Event | Directive
--- | ---
click | `wire:click`
keydown | `wire:keydown`
submit | `wire:submit`
@endcomponent

Here are a few examples of each in HTML:

@component('components.code')
<button wire:click="doSomething">Do Something</button>
@endcomponent

@component('components.code')
<input wire:keydown.enter="doSomething">
@endcomponent

@component('components.code')
<form wire:submit.prevent="save">
    ...

    <button>Save</button>
</form>
@endcomponent

@component('components.tip')
You can listen for any event dispatched by the element you are binding to. Let's say you have an element that dispatches a browser event called "foo", you could listen for that event like so: <code>&lt;button wire:foo="someAction"&gt;</code>
@endcomponent

## Passing Action Parameters {#action-parameters}

You can pass extra parameters into a Livewire action directly in the expression like so:

@component('components.code')
@verbatim

<button wire:click="addTodo({{ $todo->id }}, '{{ $todo->name }}')">
    Add Todo
</button>

@endverbatim
@endcomponent

Extra parameters passed to an action, will be passed through to the component's method as standard PHP params:

@component('components.code', ['lang' => 'php'])
@verbatim

public function addTodo($id, $name)
{
    ...
}

@endverbatim
@endcomponent

Action parameters are also capable of directly resolving a model by its key using a type hint.

@component('components.code', ['lang' => 'php'])
@verbatim

public function addTodo(Todo $todo, $name)
{
    ...
}

@endverbatim
@endcomponent

If your action requires any services that should be resolved via Laravel's dependency injection container, you can list them in the action's signature before any additional parameters:

@component('components.code', ['lang' => 'php'])
@verbatim

public function addTodo(TodoService $todoService, $id, $name)
{
    ...
}

@endverbatim
@endcomponent

## Event Modifiers {#event-modifiers}

Like you saw in the **keydown** example, Livewire directives sometimes offer "modifiers" to add extra functionality to an event. Below are the available modifiers that can be used with any event.

@component('components.table')
Modifier | Description
--- | ---
stop | Equivalent of `event.stopPropagation()`
prevent | Equivalent of `event.preventDefault()`
self | Only triggers an action if the event was triggered on itself. This prevents outer elements from catching events that were triggered from a child element. (Like often in the case of registering a listener on a modal backdrop)
debounce.150ms | Adds an Xms debounce the handling of the action.
@endcomponent

### Keydown Modifiers {#keydown-modifiers}

To listen for specific keys on **keydown** events, you can pass the name of the key as a modifier. You can directly use any valid key names exposed via [KeyboardEvent.key](https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key/Key_Values) as modifiers by converting them to kebab-case.

Here is a quick list of some common ones you may need:

@component('components.table')
Native Browser Event | Livewire Modifier
--- | ---
Backspace | backspace
Escape | escape
Shift | shift
Tab | tab
ArrowRight | arrow-right
@endcomponent

@component('components.code')
<input wire:keydown.page-down="foo">
@endcomponent

In the above example, the handler will only be called if `event.key` is equal to 'PageDown'.

## Magic Actions {#magic-actions}
In Livewire, there are some "magic" actions that are usually prefixed with a "$" symbol:

@component('components.table')
Function | Description
--- | ---
$refresh | Will re-render the component without firing any action
$set('_property_', _value_) | Shortcut to update the value of a property
$toggle('_property_') | Shortcut to toggle boolean properties on or off
$emit('_event_', _...params_) | Will emit an event on the global event bus, with the provided params
$event | A _special_ variable that holds the value of the event fired that triggered the action. Example usage: `wire:change="setSomeProperty($event.target.value)"`
@endcomponent

You can pass these as the value of an event listener to do special things in Livewire.

Let's take `$set()` for example. It can be used to manually set a component property's value. Consider the `Counter` component's view.

**Before**

@component('components.code', ['lang' => 'php'])
@verbatim
<div>
    {{ $message }}
    <button wire:click="setMessageToHello">Say Hi</button>
</div>
@endverbatim
@endcomponent

**After**

@component('components.code', ['lang' => 'php'])
@verbatim
<div>
    {{ $message }}
    <button wire:click="$set('message', 'Hello')">Say Hi</button>
</div>
@endverbatim
@endcomponent

Notice that we are no longer calling the `setMessageToHello` function, we are directly specifying, what we want data set to.

It can also be used in the backend when listening for an event. For example, if you have one component that emits an event like this:

@component('components.code', ['lang' => 'php'])
@verbatim
$this->emit('some-event');
@endverbatim
@endcomponent

Then in another component you can use a magic action for example `$refresh()` instead of having to point the listener to a method:

@component('components.code', ['lang' => 'php'])
@verbatim
protected $listeners = ['some-event' => '$refresh'];
@endverbatim
@endcomponent
