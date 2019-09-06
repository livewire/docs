---
title: Polling
extends: _layouts.documentation
section: content
---

Livewire offers a directive called `wire:poll` that, when added to an element, will refresh the component every `5s`.

@tip
Polling for changes over Ajax is a lightweight, simpler alternative to something like Laravel Echo, Pusher, or any WebSocket strategy.
@endtip

@code
@verbatim
<div wire:poll>
    Current time: {{ now() }}
</div>
@endverbatim
@endcode

You can customize the frequency by passing a directive modifier like `750ms`. For example:

@code
@verbatim
<div wire:poll.750ms>
    Current time: {{ now() }}
</div>
@endverbatim
@endcode

You can also specify a specific action to fire on the polling interval by passing a value to `wire:poll`:

@code
@verbatim
<div wire:poll="foo">
    Current time: {{ now() }}
</div>
@endverbatim
@endcode

Now, the `foo` method on the component will be called every 5 seconds.
