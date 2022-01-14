* [Introduction](#introduction)
* [Polling in the background](#polling-background)
* [Polling only when element is visible](#polling-element-visible)

## Introduction {#introduction}

Livewire offers a directive called `wire:poll` that, when added to an element, will refresh the component every `2s`.

@component('components.tip')
Polling for changes over Ajax is a lightweight, simpler alternative to something like Laravel Echo, Pusher, or any WebSocket strategy.
@endcomponent

@component('components.code')
@verbatim
<div wire:poll>
    Current time: {{ now() }}
</div>
@endverbatim
@endcomponent

You can customize the frequency by passing a directive modifier like `750ms`. For example:

@component('components.code')
@verbatim
<div wire:poll.750ms>
    Current time: {{ now() }}
</div>
@endverbatim
@endcomponent

You can also specify a specific action to fire on the polling interval by passing a value to `wire:poll`:

@component('components.code')
@verbatim
<div wire:poll="foo">
    Current time: {{ now() }}
</div>
@endverbatim
@endcomponent

Now, the `foo` method on the component will be called every 2 seconds.


## Polling in the background {#polling-background}

Livewire reduces polling when the browser tab is in the background so that it doesn't bog down the server with ajax requests unnecessarily.
Only about 5% of the expected polling requests are kept.

If you'd like to keep polling at the normal rate even while the tab is in the background, you can use the `keep-alive` modifier:

@component('components.code')
@verbatim
<div wire:poll.keep-alive>
    Current time: {{ now() }}
</div>
@endverbatim
@endcomponent

## Polling only when element is visible {#polling-element-visible}

If your component isn't always visible in the browser's viewport (further down the page for example), you can opt to only poll the server when an element is visible by adding the `.visible` modifier to `wire:poll`. For example:

@component('components.code')
@verbatim
<div wire:poll.visible></div>
@endverbatim
@endcomponent
