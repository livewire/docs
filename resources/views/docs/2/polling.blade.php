
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

@component('components.tip')
Livewire reduces polling when the browser tab is in the background so that it doesn't bog down the server with ajax requests unnecessarily.
Only about 5% of the expected polling requests are kept.
@endcomponent
