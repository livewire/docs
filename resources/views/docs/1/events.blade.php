* [Firing Events](#firing-events) { .text-blue-800 }
  * [From The Template](#from-template) { .font-normal.text-sm.text-blue-800 }
  * [From The Component](#from-component) { .font-normal.text-sm.text-blue-800 }
  * [From Global JavaScript](#from-js) { .font-normal.text-sm.text-blue-800 }
* [Event Listeners](#event-listeners) { .text-blue-800 }
* [Passing Parameters](#passing-parameters) { .text-blue-800 }
* [Scoping Events](#scoping-events) { .text-blue-800 }
  * [Scoping To Parent Listeners](#scope-to-parents) { .font-normal.text-sm.text-blue-800 }
  * [Scoping To Components By Name](#scope-by-name) { .font-normal.text-sm.text-blue-800 }
  * [Scoping To Self](#scope-to-self) { .font-normal.text-sm.text-blue-800 }
* [Listening For Events In JavaScript](#in-js) { .text-blue-800 }
* [Dispatching Browser Events](#browser) { .text-blue-800 }

<div>&nbsp;</div>

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

### Method C: From Global JavaScript {#from-js}

@component('components.code', ['lang' => 'javascript'])
<script>
    Livewire.emit('postAdded')
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

## Passing Parameters {#passing-parameters}

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

## Scoping Events {#scoping-events}

## Scoping To Parent Listeners {#scope-to-parents}
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
Sometimes you may only want to emit an event on the component that fired the event. This is sometimes useful for firing an event in PHP and listening for it in JavaScript.

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

@component('components.code', ['lang' => 'html'])
<div x-data="{ open: false }" @name-updated.window="open = false">
    <!-- Modal with a Livewire name update form -->
</div>
@endcomponent
