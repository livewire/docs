---
title: Events
extends: _layouts.documentation
section: content
---

Livewire components can communicate with each other through a global event system. As long as two Livewire components are living on the same page, they can communicate using events and listeners.

## Firing Events {#firing-events}

There are multiple ways to fire events from Livewire components.

### Method A: From The Template {#from-template}

@code
<button wire:click="$emit('postAdded')">
@endcode

### Method B: From The Component {#from-component}

@code(['lang' => 'php'])
$this->emit('postAdded');
@endcode

### Method C: From Global JavaScript {#from-javascript}

@code(['lang' => 'javascript'])
<script>
    window.livewire.emit('postAdded')
</script>
@endcode

## Event Listeners {#event-listeners}
Event listeners are registered in the `$listeners` property of your Livewire components.

Listeners are a key->value pair where the key is the event to listen for, and the value is the method to call on the component.

@codeComponent(['className' => 'ShowPosts'])
@slot('class')
use Livewire\Component;

class ShowPosts extends Component
{
    public $addedMessageVisible = false;

    protected $listeners = ['postAdded' => 'showPostAddedMessage'];

    public function showPostAddedMessage()
    {
        $this->addedMessageVisible = true;
    }

    public function render()
    {
        return view('livewire.show-posts');
    }
}
@endslot
@endcodeComponent

Now when any other component on the page emits a `postAdded` event, this component will pick it up and fire the `showPostAddedMessage` method on itself.

@tip
If the name of the event and the method you're calling match, you can leave out the key. For example: <code>protected $listeners = ['postAdded'];</code> will call the <code>postAdded</code> method when the <code>postAdded</code> event is emitted.
@endtip

If you need to name event listeners dynamically, you can substitute the `$listeners` property for the `getListeners()` protected method on the component:

@codeComponent(['className' => 'ShowPosts'])
@slot('class')
use Livewire\Component;

class ShowPosts extends Component
{
    public $addedMessageVisible = false;

    protected function getListeners()
    {
        return ['postAdded' => 'showPostAddedMessage'];
    }

    ...
}
@endslot
@endcodeComponent

### Passing Parameters {#passing-parameters}

You can also send parameters with an event emission.

@code(['lang' => 'php'])
$this->emit('postAdded', $post->id);
@endcode

@codeComponent(['className' => 'ShowPosts'])
@slot('class')
use Livewire\Component;

class ShowPosts extends Component
{
    public $addedMessageVisible = false;
    public $addedPost;

    protected $listeners = ['postAdded'];

    public function postAdded($postId)
    {
        $this->addedMessageVisible = true;
        $this->addedPost = Post::find($postId);
    }

    public function render()
    {
        return view('livewire.show-posts');
    }
}
@endslot
@endcodeComponent

### Scoping Events To Parent Listeners {#scope-events-to-parents}
When dealing with [nested components](/docs/nesting-components), sometimes you may only want to emit events to parents and not children or sibling components.

In these cases, can use the `emitUp` feature:

@code
<button wire:click="$emitUp('postAdded')">
@endcode

@code(['lang' => 'php'])
$this->emitUp('postAdded');
@endcode

## Listening for events in JavaScript {#in-js}

Livewire allows you to register event listeners in JavaScript like so:

@code(['lang' => 'javascript'])
<script>
window.livewire.on('postAdded', postId => {
    alert('A post was added with the id of: ' + postId);
})
</script>
@endcode

@tip
This feature is actually incredibly powerful. For example, you could register a listener to show a toaster (popup) inside your app when Livewire performs certain actions. This is one of the many ways to bridge the gap between PHP and JavaScript with Livewire.
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
