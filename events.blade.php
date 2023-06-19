* [Firing Events](#firing-events)
  * [From The Template](#from-template)
  * [From The Component](#from-component)
  * [From Global JavaScript](#from-js)
* [Event Listeners](#event-listeners)
* [Passing Parameters](#passing-parameters)
* [Scoping Events](#scoping-events)
  * [Scoping To Parent Listeners](#scope-to-parents)
  * [Scoping To Components By Name](#scope-by-name)
  * [Scoping To Self](#scope-to-self)
* [Listening For Events In JavaScript](#in-js)
* [Dispatching Browser Events](#browser)

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

### Method C: From Global JavaScript {#from-js}

@component('components.code', ['lang' => 'javascript'])
<script>
    Livewire.emit('postAdded')
</script>
@endcomponent

## Event Listeners {#event-listeners}
Event listeners are registered in the `$listeners` property of your Livewire components.

Listeners are a key->value pair where the key is the event to listen for, and the value is the method to call on the component.

@component('components.code', ['lang' => 'php'])
class ShowPosts extends Component
{
    public $postCount;

    protected $listeners = ['postAdded' => 'incrementPostCount'];

    public function incrementPostCount()
    {
        $this->postCount = Post::count();
    }
}
@endcomponent

Now when any other component on the page emits a `postAdded` event, this component will pick it up and fire the `incrementPostCount` method on itself.

@component('components.tip')
If the name of the event and the method you're calling match, you can leave out the key. For example: <code>protected $listeners = ['postAdded'];</code> will call the <code>postAdded</code> method when the <code>postAdded</code> event is emitted.
@endcomponent

If you need to name event listeners dynamically, you can substitute the `$listeners` property for the `getListeners()` protected method on the component:

@component('components.code-component')
@slot('class')
class ShowPosts extends Component
{
    public $postCount;

    protected function getListeners()
    {
        return ['postAdded' => 'incrementPostCount'];
    }

    ...
}
@endslot
@endcomponent

@component('components.warning')
<code>getListeners()</code> will only dynamically generate the names of listeners when the component is mounted. Once the listeners are setup, these can't be changed.
@endcomponent

## Passing Parameters {#passing-parameters}

You can also send parameters with an event emission.

@component('components.code', ['lang' => 'php'])
$this->emit('postAdded', $post->id);
@endcomponent

@component('components.code-component')
@slot('class')
class ShowPosts extends Component
{
    public $postCount;
    public $recentlyAddedPost;

    protected $listeners = ['postAdded'];

    public function postAdded(Post $post)
    {
        $this->postCount = Post::count();
        $this->recentlyAddedPost = $post;
    }
}
@endslot
@endcomponent

## Scoping Events {#scoping-events}

### Scoping To Parent Listeners {#scope-to-parents}
When dealing with [nested components](nesting-components), sometimes you may only want to emit events to parents and not children or sibling components.

In these cases, you can use the `emitUp` feature:

@component('components.code', ['lang' => 'php'])
$this->emitUp('postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitUp('postAdded')">
@endcomponent

### Scoping To Components By Name {#scope-by-name}
Sometimes you may only want to emit an event to other components of the same type.

In these cases, you can use `emitTo`:

@component('components.code', ['lang' => 'php'])
$this->emitTo('counter', 'postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitTo('counter', 'postAdded')">
@endcomponent

(Now, if the button is clicked, the "postAdded" event will only be emitted to `counter` components)

### Scoping To Self {#scope-to-self}
Sometimes you may only want to emit an event on the component that fired the event.

In these cases, you can use `emitSelf`:

@component('components.code', ['lang' => 'php'])
$this->emitSelf('postAdded');
@endcomponent

@component('components.code')
<button wire:click="$emitSelf('postAdded')">
@endcomponent

(Now, if the button is clicked, the "postAdded" event will only be emitted to the instance of the component that it was emitted from.)

## Listening For Events In JavaScript {#in-js}

Livewire allows you to register event listeners in JavaScript like so:

@component('components.code', ['lang' => 'javascript'])
<script>
Livewire.on('postAdded', postId => {
    alert('A post was added with the id of: ' + postId);
})
</script>
@endcomponent

@component('components.tip')
This feature is actually incredibly powerful. For example, you could register a listener to show a toaster (popup) inside your app when Livewire performs certain actions. This is one of the many ways to bridge the gap between PHP and JavaScript with Livewire.
@endcomponent

## Dispatching Browser Events {#browser}

Livewire allows you to fire browser window events like so:

@component('components.code', ['lang' => 'php'])
$this->dispatchBrowserEvent('name-updated', ['newName' => $value]);
@endcomponent

You are able to listen for this window event with JavaScript:

@component('components.code', ['lang' => 'javascript'])
<script>
window.addEventListener('name-updated', event => {
    alert('Name updated to: ' + event.detail.newName);
})
</script>
@endcomponent

AlpineJS allows you to easily listen for these window events within your HTML:

@component('components.code', ['lang' => 'blade'])
<div x-data="{ open: false }" @name-updated.window="open = true">
    <!-- Modal with a Livewire name update form -->
</div>
@endcomponent
