---
title: Events
description: todo
extends: _layouts.documentation
section: content
---

# Events

Livewire components can communicate with each other through a global event system. As long as two Livewire components are living on the same page, they can communicate using events and listeners.

## Firing Events {#firing-events}

There are multiple ways to fire events from Livewire components.

### Method A: From The Template {#from-template}
This method is twice as fast as Method B, so it is the preferred usage.

@code
<button wire:click="$emit('showModal')">
@endcode

### Method B: From The Component {#from-component}

@code(['lang' => 'php'])
$this->emit('showModal');
@endcode

### Method C: From JavaScript {#from-javascript}

@code(['lang' => 'javascript'])
<script>
    window.livewire.emit('showModal')
</script>
@endcode

## Listening for events in PHP {#in-php}
Event listeners are registered in the `$listeners` property of your Livewire components.

@codeComponent(['className' => 'Modal'])
@slot('class')
use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;

    protected $listeners = ['showModal' => 'open'];

    public function open()
    {
        $this->isOpen = true;
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
@endslot
@endcodeComponent

Now when any other component on the page emits a `showModal` event, this component will pick it up and fire the `open` method on itself.

## Listening for events in JavaScript {#in-js}

Livewire allows you to register event listeners in JavaScript like so:

@code(['lang' => 'javascript'])
<script>
window.livewire.on('foo', param => {
    alert('The foo event was called with the param: ' + param);
})
</script>
@endcode

@tip
This feature is actually incredibly powerful. It provides a bridge between Livewire and other JS inside your app. For example, if you had a JavaScript function to show a toaster (popup) inside your app to show notification messages, you could trigger them from inside your Livewire component with this feature.
@endtip

## Listening for Laravel Echo events {#echo-events}

Livewire pairs nicely with Laravel Echo to provide real-time functionality on your web-pages using WebSockets.

@warning
This feature assumes you have installed Laravel Echo and the `window.Echo` object is globally available. For more info on this, check out the <a href="https://laravel.com/docs/5.8/broadcasting#installing-laravel-echo">docs</a>.
@endwarning

Consider the following Laravel Event:

@codeComponent(['className' => 'OrderShipped'])
@slot('class')
class OrderShipped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('orders');
    }
}
@endslot
@endcodeComponent


Let's say you fire this event with Laravel's broadcasting system like this:

@code(['lang' => 'php'])
event(new OrderShipped);
@endcode

Normally, you would listen for this event in Laravel Echo like so:

@code(['lang' => 'js'])
    Echo.channel('orders')
        .listen('OrderShipped', (e) => {
            console.log(e.order.name);
        });
@endcode

With Livewire however, all you have to do is register it in your `$listeners` property, with some special syntax to designate it's from Echo.

@codeComponent(['className' => 'OrderTracker'])
@slot('class')
use Livewire\Component;

class OrderTracker extends Component
{
    public $showNewOrderNotication = false;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = ['echo:orders,OrderShipped' => 'notifyNewOrder'];

    public function notifyNewOrder()
    {
        $this->showNewOrderNotification = true;
    }

    public function render()
    {
        return view('livewire.order-tracker');
    }
}
@endslot
@endcodeComponent

Now, Livewire will intercept the received event from Pusher, and act accordingly.
