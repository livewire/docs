@include('includes.screencast-cta')

Livewire components can communicate with each other through a global event system. As long as two Livewire components are living on the same page, they can communicate using events and listeners.

## Firing Events {#firing-events}

There are multiple ways to fire events from Livewire components.

### Method A: From The Template {#from-template}

@component('components.code')
<button wire:click="$emit('postAdded')">
@endcomponent

### Method B: From The Component {#from-component}

@component('components.code', ['lang' => 'php'])
$this->emit('postAdded');
@endcomponent

### Method C: From Global JavaScript {#from-javascript}

@component('components.code', ['lang' => 'javascript'])
<script>
    window.livewire.emit('postAdded')
</script>
@endcomponent

## Event Listeners {#event-listeners}
Event listeners are registered in the `$listeners` property of your Livewire components.

Listeners are a key->value pair where the key is the event to listen for, and the value is the method to call on the component.

@component('components.code-component', ['className' => 'ShowPosts'])
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
@endcomponent

Now when any other component on the page emits a `postAdded` event, this component will pick it up and fire the `showPostAddedMessage` method on itself.

@component('components.tip')
If the name of the event and the method you're calling match, you can leave out the key. For example: <code>protected $listeners = ['postAdded'];</code> will call the <code>postAdded</code> method when the <code>postAdded</code> event is emitted.
@endcomponent

If you need to name event listeners dynamically, you can substitute the `$listeners` property for the `getListeners()` protected method on the component:

@component('components.code-component', ['className' => 'ShowPosts'])
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
@endcomponent

### Passing Parameters {#passing-parameters}

You can also send parameters with an event emission.

@component('components.code', ['lang' => 'php'])
$this->emit('postAdded', $post->id);
@endcomponent

@component('components.code-component', ['className' => 'ShowPosts'])
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
@endcomponent

### Scoping Events To Parent Listeners {#scope-events-to-parents}
When dealing with [nested components](/docs/nesting-components), sometimes you may only want to emit events to parents and not children or sibling components.

In these cases, can use the `emitUp` feature:

@component('components.code', ['lang' => 'php'])
$this->emitUp('postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitUp('postAdded')">
@endcomponent

### Scoping Events To Components By Name{#scope-events-to-components}
Sometimes you may only want to emit an event to other components of the same type.

In these cases, can use `emitTo`:

@component('components.code', ['lang' => 'php'])
$this->emitTo('counter', 'postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitTo('counter', 'postAdded')">
@endcomponent

(Now, if the button is clicked, the "postAdded" event will only be emitted to `counter` components)

### Scoping Events To Self {#scope-events-to-self}
Sometimes you may only want to emit an event on the component that fired the event. This is sometimes useful for firing an event in PHP and listening for it in JavaScript.

In these cases, can use `emitSelf`:

@component('components.code', ['lang' => 'php'])
$this->emitSelf('postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitSelf('postAdded')">
@endcomponent

(Now, if the button is clicked, the "postAdded" event will only be emitted to the instance of the component that it was emitted from.)

## Listening for events in JavaScript {#in-js}

Livewire allows you to register event listeners in JavaScript like so:

@component('components.code', ['lang' => 'javascript'])
<script>
window.livewire.on('postAdded', postId => {
    alert('A post was added with the id of: ' + postId);
})
</script>
@endcomponent

@component('components.tip')
This feature is actually incredibly powerful. For example, you could register a listener to show a toaster (popup) inside your app when Livewire performs certain actions. This is one of the many ways to bridge the gap between PHP and JavaScript with Livewire.
@endcomponent

## Listening for Laravel Echo events {#echo-events}

Livewire pairs nicely with Laravel Echo to provide real-time functionality on your web-pages using WebSockets.

@component('components.warning')
This feature assumes you have installed Laravel Echo and the `window.Echo` object is globally available. For more info on this, check out the <a href="https://laravel.com/docs/broadcasting#installing-laravel-echo">docs</a>.
@endcomponent

Consider the following Laravel Event:

@component('components.code-component', ['className' => 'OrderShipped'])
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

With Livewire however, all you have to do is register it in your `$listeners` property, with some special syntax to designate it's from Echo.

@component('components.code-component', ['className' => 'OrderTracker'])
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
@endcomponent

Now, Livewire will intercept the received event from Pusher, and act accordingly.
