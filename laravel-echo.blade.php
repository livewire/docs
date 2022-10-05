* [Introduction](#introduction)
* [Listeners](#listeners)
* [Private & Presence Channels](#private-presence-channels)

## Introduction {#introduction}

Livewire pairs nicely with Laravel Echo to provide real-time functionality on your web-pages using WebSockets.

@component('components.warning')
This feature assumes you have installed Laravel Echo and the `window.Echo` object is globally available. For more info on this, check out the <a href="https://laravel.com/docs/broadcasting#client-side-installation">docs</a>.
@endcomponent

Consider the following Laravel Event:

@component('components.code-component')
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
@endcomponent

Let's say you fire this event with Laravel's broadcasting system like this:

@component('components.code', ['lang' => 'php'])
event(new OrderShipped);
@endcomponent

Normally, you would listen for this event in Laravel Echo like so:

@component('components.code', ['lang' => 'js'])
    Echo.channel('orders')
        .listen('OrderShipped', (e) => {
            console.log(e.order.name);
        });
@endcomponent

## Listeners {#listeners}

With Livewire all you have to do is register it in your `$listeners` property, with some special syntax to designate that it originates from Echo.

@component('components.code-component')
@slot('class')
class OrderTracker extends Component
{
    public $showNewOrderNotification = false;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = ['echo:orders,OrderShipped' => 'notifyNewOrder'];

    public function notifyNewOrder()
    {
        $this->showNewOrderNotification = true;
    }
}
@endslot
@endcomponent

If you have Echo channels with variables in (such as a Order ID) you can use the `getListeners()` function instead of the `$listeners` array.

@component('components.code-component')
@slot('class')
class OrderTracker extends Component
{
    public $showNewOrderNotification = false;
    public $orderId;
    
    public function getListeners()
    {
        return [
            "echo:orders.{$this->orderId},OrderShipped" => 'notifyNewOrder',
        ];
    }

    public function notifyNewOrder()
    {
        $this->showNewOrderNotification = true;
    }
}
@endslot
@endcomponent

Now, Livewire will intercept the received event from Pusher, and act accordingly.

## Private & Presence Channels {#private-presence-channels}

In a similar way to regular public channels, you can also listen to events broadcasted to private and presence channels:

@component('components.warning')
    Make sure you have your <a href="https://laravel.com/docs/master/broadcasting#defining-authorization-callbacks">Authentication Callbacks</a> properly defined.
@endcomponent

@component('components.code-component')
@slot('class')
class OrderTracker extends Component
{
    public $showNewOrderNotification = false;
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getListeners()
    {
        return [
            "echo-private:orders.{$this->orderId},OrderShipped" => 'notifyNewOrder',
            // Or:
            "echo-presence:orders.{$this->orderId},OrderShipped" => 'notifyNewOrder',
        ];
    }

    public function notifyNewOrder()
    {
        $this->showNewOrderNotification = true;
    }
}
@endslot
@endcomponent

This gives you the ability to react to a listen event on those channels with the `OrderShipped` event name. 
You can also access the `joining | leaving | here` events of a presence channels with a slight change to the syntax.

@component('components.code-component')
@slot('class')
class OrderTracker extends Component
{
    public $showNewOrderNotification = false;
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getListeners()
    {
        return [
            // Public Channel
            "echo:orders,OrderShipped" => 'notifyNewOrder',
            
            // Private Channel
            "echo-private:orders,OrderShipped" => 'notifyNewOrder',
            
            //Presence Channel
            "echo-presence:orders,OrderShipped" => 'notifyNewOrder',    // Listen
            "echo-presence:orders,here" => 'notifyNewOrder',            // Here
            "echo-presence:orders,joining" => 'notifyNewOrder',         // Joining
            "echo-presence:orders,leaving" => 'notifyNewOrder',         // Leaving
        ];
    }

    public function notifyNewOrder()
    {
        $this->showNewOrderNotification = true;
    }
}
@endslot
@endcomponent
