---
title: Actions
extends: _layouts.documentation
section: content
---

The goal of actions in Livewire is to be able to easily listen to page interactions, and call a method on your Livewire component (re-rendering the component).

Here's the basic usage:

@codeComponent([
    'className' => 'ShowPost.php',
    'viewName' => 'show-post.blade.php',
])
@slot('class')
use Livewire\Component;

class ShowPost extends Component
{
    ...

    public function addLike()
    {
        $this->post->addLikeBy(auth()->user());
    }

    public function render()
    {
        return view('livewire.show-post');
    }
}
@endslot
@slot('view')
@verbatim
<div>
    ...

    <button wire:click="addLike">Like Post</button>
</div>
@endverbatim
@endslot
@endcodeComponent

Livewire currently offers a handful of directives to make listening to browser events trivial. The common format for all of them is: `wire:[dispatched browser event]="[action]"`.

Here are some common events you may need to listen for:

@table
Event | Directive
--- | ---
click | `wire:click`
keydown | `wire:keydown`
submit | `wire:submit`
@endtable

Here are a few examples of each in HTML:

**click**
@code
<button wire:click="doSomething">Do Something</button>
@endcode

**keydown**
@code
<input wire:keydown.enter="doSomething">
@endcode

**submit**
@code
<form wire:submit.prevent="save">
    ...

    <button>Save</button>
</form>
@endcode

@tip
You can listen for any event dispatched by the element you are binding to. Let's say you have an element that dispatches a browser event called "foo", you could listen for that event like so: <code>&lt;button wire:foo="someAction"&gt;</code>
@endtip

## Parameters {#parameters}

You can pass extra parameters into a Livewire action directly in the expression like so:

@code
@verbatim

<button wire:click="addTodo({{ $todo->id }}, '{{ $todo->name }}')">Add Todo</button>

@endverbatim
@endcode

Extra parameters passed to an action, will be passed through to the component's method as standard PHP params:

@code(['lang' => 'php'])
@verbatim

public function addTodo($id, $name)
{
    ...
}

@endverbatim
@endcode

If your action requires any services that should be resolved via Laravel's dependency injection container, you may list them in the action's signature before any additional parameters:

@code(['lang' => 'php'])
@verbatim

public function addTodo(TodoService $todoService, $id, $name)
{
    ...
}

@endverbatim
@endcode

## Modifiers {#modifiers}

Like you saw in the **keydown** example, Livewire directives sometimes offer "modifiers" to add extra functionality to an event. Below are the available modifiers that can be used with any event.

@table
Modifier | Description
--- | ---
stop | Equivalent of `event.stopPropagation()`
prevent | Equivalent of `event.preventDefault()`
self | Only triggers an action if the event was triggered on itself. This prevents outer elements from catching events that were triggered from a child element. (Like often in the case of registering a listener on a modal backdrop)
debounce.150ms | Adds an Xms debounce the handling of the action.
@endtable

## Keydown Modifiers {#keydown-modifiers}

To listen for specific keys on **keydown** events, you can pass the name of the key as a modifier. You can directly use any valid key names exposed via [KeyboardEvent.key](https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key/Key_Values) as modifiers by converting them to kebab-case.

Here is a quick list of some common ones you may need:

@table
Native Browser Event | Livewire Modifier
--- | ---
Backspace | backspace
Escape | escape
Shift | shift
Tab | tab
ArrowRight | arrow-right
@endtable

@code
<input wire:keydown.page-down="foo">
@endcode

In the above example, the handler will only be called if `event.key` is equal to 'PageDown'.

## Special Actions {#special-actions}
In Livewire, there are some "special" actions that are usually prefixed with a "$" symbol:

@table
Function | Description
--- | ---
$refresh | Will re-render the component without firing any action
$set('_property_', _value_) | Shortcut to update the value of a property
$toggle('_property_') | Shortcut to toggle boolean properties on or off
$emit('_event_', _...params_) | Will emit an event on the global event bus, with the provided params
$event | A _special_ variable that holds the value of the event fired that triggered the action. Example usage: `wire:change="setSomeProperty($event.target.value)"`
@endtable

You can pass these as the value of an event listener to do special things in Livewire.

Let's take `$set()` for example. It can be used to manually set a component property's value. Consider the `Counter` component's view.

**Before**

@code(['lang' => 'php'])
@verbatim
<div>
    {{ $message }}
    <button wire:click="setMessageToHello">Say Hi</button>
</div>
@endverbatim
@endcode

**After**

@code(['lang' => 'php'])
@verbatim
<div>
    {{ $message }}
    <button wire:click="$set('message', 'Hello')">Say Hi</button>
</div>
@endverbatim
@endcode

Notice that we are no longer calling the `setMessageToHello` function, we are directly specifying, what we want data set to.
