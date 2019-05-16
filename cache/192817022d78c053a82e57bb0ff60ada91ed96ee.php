---
title: Events
description: todo
extends: _layouts.documentation
section: content
---

Livewire components can communicate with each other through a global event system. As long as two Livewire components are living on the same page, they can communicate using events and listeners.

## Firing Events

There are two ways to fire events from Livewire components.

### Method A: From The Template
This method is twice as fast as Method B, so it is the preffered usage.

```html
<button wire:click="$emit('showModal')">
```

### Method B: From The Component

```php
$this->emit('showModal');
```

## Listening For Events
Event listeners are registered in the `$listeners` property of your Livewire components.

<div title="Component"><div title="Component__class">

Modal
```php
class Modal extends LivewireComponent
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
```
</div></div>

Now when any other component on the page emits a `showModal` event, this component will pick it up and fire the `open` method on itself.

## Listening for Laravel Echo events

Livewire pairs nicely with Laravel Echo to provide real-time functionality on your web-pages using WebSockets.

<div title="Warning"><div title="Warning__content">

This feature assumes you have installed Laravel Echo and the `window.Echo` object is globally available. For more info on this, check out the [docs](https://laravel.com/docs/5.8/broadcasting#installing-laravel-echo).
</div></div>

Consider the following Laravel Event:

<div title="Component"><div title="Component__class">

Modal
```php
class OrderShipped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('orders');
    }
}

```
</div></div>

Let's say you fire this event with Laravel's broadcasting system like this:

```php
event(new OrderShipped);
```

Normally, you would listen for this event in Laravel Echo like so:

```js
    Echo.channel('orders')
        .listen('OrderShipped', (e) => {
            console.log(e.order.name);
        });
```

With Livewire however, all you have to do is register it in your `$listeners` property, with some special syntax to designate it's from Echo.

<div title="Component"><div title="Component__class">

OrderTracker
```php
class OrderTracker extends LivewireComponent
{
    public $showNewOrderNotication = false;

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
```
</div></div>

Now, Livewire will intercept the received event from Pusher, and act accordingly.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/31fd3054f0ba95e7daac247a2b6fc113ac1ab4a0.blade.md ENDPATH**/ ?>