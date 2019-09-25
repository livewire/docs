---
title: Events
extends: _layouts.documentation
section: content
---

Livewire components can communicate with each other through a global event system. As long as two Livewire components are living on the same page, they can communicate using events and listeners.

## Firing Events {#firing-events}

There are multiple ways to fire events from Livewire components.

### Method A: From The Template {#from-template}
This method is twice as fast as Method B, so it is the preferred usage.

<?php $__env->startComponent('_partials.code'); ?>
<button wire:click="$emit('showModal')">
<?php echo $__env->renderComponent(); ?>

### Method B: From The Component {#from-component}

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
$this->emit('showModal');
<?php echo $__env->renderComponent(); ?>

### Method C: From JavaScript {#from-javascript}

<?php $__env->startComponent('_partials.code', ['lang' => 'javascript']); ?>
<script>
    window.livewire.emit('showModal')
</script>
<?php echo $__env->renderComponent(); ?>

## Listening for events in PHP {#in-php}
Event listeners are registered in the `$listeners` property of your Livewire components.

<?php $__env->startComponent('_partials.code-component', ['className' => 'Modal']); ?>
<?php $__env->slot('class'); ?>
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
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

Now when any other component on the page emits a `showModal` event, this component will pick it up and fire the `open` method on itself.

<?php $__env->startComponent('_partials.tip'); ?>
You can also send parameters through the event bus.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
$this->emit('showModal', 'My custom message for the modal');
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code-component', ['className' => 'Modal']); ?>
<?php $__env->slot('class'); ?>
use Livewire\Component;

class Modal extends Component
{
    public $message = null;
    public $isOpen = false;

    protected $listeners = ['showModal' => 'open'];

    public function open($message)
    {
        $this->isOpen = true;
        $this->message = $message; // Will be 'My custom message for the modal' 
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

## Listening for events in JavaScript {#in-js}

Livewire allows you to register event listeners in JavaScript like so:

<?php $__env->startComponent('_partials.code', ['lang' => 'javascript']); ?>
<script>
window.livewire.on('foo', param => {
    alert('The foo event was called with the param: ' + param);
})
</script>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.tip'); ?>
This feature is actually incredibly powerful. It provides a bridge between Livewire and other JS inside your app. For example, if you had a JavaScript function to show a toaster (popup) inside your app to show notification messages, you could trigger them from inside your Livewire component with this feature.
<?php echo $__env->renderComponent(); ?>

## Listening for Laravel Echo events {#echo-events}

Livewire pairs nicely with Laravel Echo to provide real-time functionality on your web-pages using WebSockets.

<?php $__env->startComponent('_partials.warning'); ?>
This feature assumes you have installed Laravel Echo and the `window.Echo` object is globally available. For more info on this, check out the <a href="https://laravel.com/docs/5.8/broadcasting#installing-laravel-echo">docs</a>.
<?php echo $__env->renderComponent(); ?>

Consider the following Laravel Event:

<?php $__env->startComponent('_partials.code-component', ['className' => 'OrderShipped']); ?>
<?php $__env->slot('class'); ?>
class OrderShipped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('orders');
    }
}
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>


Let's say you fire this event with Laravel's broadcasting system like this:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
event(new OrderShipped);
<?php echo $__env->renderComponent(); ?>

Normally, you would listen for this event in Laravel Echo like so:

<?php $__env->startComponent('_partials.code', ['lang' => 'js']); ?>
    Echo.channel('orders')
        .listen('OrderShipped', (e) => {
            console.log(e.order.name);
        });
<?php echo $__env->renderComponent(); ?>

With Livewire however, all you have to do is register it in your `$listeners` property, with some special syntax to designate it's from Echo.

<?php $__env->startComponent('_partials.code-component', ['className' => 'OrderTracker']); ?>
<?php $__env->slot('class'); ?>
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
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

Now, Livewire will intercept the received event from Pusher, and act accordingly.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/31fd3054f0ba95e7daac247a2b6fc113ac1ab4a0.blade.md ENDPATH**/ ?>