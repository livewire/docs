---
title: Triggering Actions
description: todo
extends: _layouts.documentation
section: content
---

# Triggering Actions

Livewire currently offers a handful of directives to make listening to browser events trivial. The common format for all of them is: `wire:[native event]="[action]"`.

Here are some common events you may need to listen for:

Event | Directive
--- | ---
click | `wire:click`
keydown | `wire:keydown`
submit | `wire:submit`

Here are a few examples of each in HTML:

**click**
@code
<button wire:click="showModal">Show Modal</button>
@endcode

**keydown**
@code
<input wire:keydown.enter="search">
@endcode

**submit**
@code
<form wire:submit="addTodo">
    <input wire:model="title">
    <button>Add Todo</button>
</form>
@endcode

@tip
You can listen for any event emitted by the element you are binding to. Let's say you have an element that fires a browser event called "foo", you could listen for that event like so: <code>&lt;button wire:foo="someAction"&gt;</code>
@endtip

## Modifiers {#modifiers}

Like you saw in the **keydown** example, Livewire directives sometimes offer "modifiers" to add extra functionality to an event. Below are the available modifiers that can be used with any event:

Modifier | Description
--- | ---
stop | Equivalent of `event.stopPropagation()`
prevent | Equivalent of `event.preventDefault()`
prefetch | Will "prefetch" and queue the result of an action (on mouseover), and display if the action is triggered

## Keydown Modifiers {#keydown-modifiers}

To listen for specific keys on **keydown** events, you can pass the name of the key as a modifier. You can directly use any valid key names exposed via [KeyboardEvent.key](https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key/Key_Values) as modifiers by converting them to kebab-case.

Here is a quick list of some common ones you may need:

Native Browser Event | Livewire Modifier
--- | ---
Backspace | backspace
Escape | escape
Shift | shift
Tab | tab
ArrowRight | arrow-right

@code
<input wire:keydown.page-down="foo">
@endcode

In the above example, the handler will only be called if `event.key` is equal to 'PageDown'.

## Special Actions {#special-actions}
In Livewire, there are some "special" actions that are usually prefixed with a "$" symbol:

Function | Description
--- | ---
$set('_property_', _value_) | Shortcut to update the value of a property
$toggle('_property_') | Shortcut to toggle boolean properties on or off
$refresh | Will re-render the component without firing any action
$emit('_event_', _...params_) | Will emit an event on the global event bus, with the provided params
$event | A _special_ variable that holds the value of the event fired that triggered the action. Example usage: `wire:change="setSomeProperty($event.target.value)"`

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

@tip
This can save on lots of redundant, one-line component methods that only exist to set, or toggle the value of component property.
@endtip

## Prefetching Actions {#prefetching-actions}
Livewire offers the ability to "prefetch" the result of an action on mouseover. This is useful for cases when an action DOES NOT perform side effects, and you want a little extra performance. Toggling content is a common use case.

Add the `prefetch` modifier to an action to enable this behavior:

@code
@verbatim
<button wire:click.prefetch="toggleContent">Show Content</button>

@if ($contentIsVisible)
    <span>Some Content...</span>
@endif
@endverbatim
@endcode

Now, when the mouse enters the "Show Content" button, Livewire will fetch the result of the "toggleContent" action in the background. If the button is actually clicked, it will display the content on the page without sending another network request. If the button is NOT clicked, the prefetched response will be thrown away.

## Polling Actions {#polling-actions}
Livewire offers a directive called `wire:poll="foo"` that, when added to an element, will fire `foo` to the Livewire component every `500ms`. You can customize the frequency by passing a directive modifier like `750ms`. For example:

@code
@verbatim
<div wire:poll.750ms="$refresh">
    Current time: {{ now() }}
</div>
@endverbatim
@endcode

## Triggering Actions On Load {#triggering-actions}
Livewire offers a `wire:init` directive to run an action as soon as the component is rendered. This can be helpful in cases where you don't want to hold up the entire page load, but want to load some data immediately after the page load.

@code
@verbatim
<div wire:init="loadTodos">
    <ul>
        @foreach ($todos as $todo)
            <li>{{ $todo }}</li>
        @endforeach
    </ul>
</div>
@endverbatim
@endcode

The `loadTodos` action will be run imediately after the Livewire component renders on the page.
