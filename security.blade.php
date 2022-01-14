* [Introduction](#introduction)
* [Security Measures](#security-measures)
    * [The Checksum](#the-checksum)
    * [Persistent Middleware](#persistent-middleware)

## Introduction {#introduction}

To the new Livewire developer, the experience is somewhat magical. It feels as if when the page loads, your Livewire component is living on a server listening for updates from the browser and responding to them in real-time.

This is not far from how other, similar tools like [Phoenix LiveView](https://dockyard.com/blog/2018/12/12/phoenix-liveview-interactive-real-time-apps-no-need-to-write-javascript) work.

However much Livewire feels similar, it has quite different inner-workings that have their own sets of pros, cons, and security implications.

Livewire components feel "stateFULL", however, they are completely "stateLESS". There is no long-running Livewire instance on the server waiting for browser interactions. Each interaction is an entirely new and fresh request/response.

To more fully grasp this mental model, let's use the following simple "counter" component as a starting point.

@component('components.code-component', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')
@verbatim
class Counter extends Component
{
    public $count = 1;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $count }}</h1>

    <button wire:click="increment">+</button>
</div>
@endverbatim
@endslot
@endcomponent

The experience of using this "counter" from a user's perspective goes like this: A user loads the page, sees the number "1", clicks the "+" button, and now sees the number "2".

Below is a visualization of how Livewire actually works to achieve this effect.

<img src="/img/lifecycle_timeline.svg" />

To summarize, when a user visits the page containing the "counter" component, a normal request is sent to the server like any other page. That page renders the initial view of the "counter" like any normal Blade component, however, in addition to rendering HTML, Livewire "dehydrates" or "serializes" the component's state (public properties) and passes it to the front-end.

Now that the front-end has the component state, when an update is triggered (clicking the "+" in this case), a request is sent to the server INCLUDING the last-known component state. The server "hydrates" or "deserializes" the component from that state and performs any updates.

The component is now dehydrated again to provide the browser with the newly rendered HTML and the updated state for use in later interactions requests.

Here is a deeper visualization of the actual component lifecycles during these requests.

<img src="/img/lifecycle_flow.svg" />

Hopefully now you've adopted a more accurate mental model of how Livewire works under the hood. This will allow you to more intelligently debug problems and understand the performance and security implications of using Livewire.

## Security Measures {#security-measures}

Like you learned above, each Livewire request is "stateless" in the sense that there is no long-running server instance maintaining state. The state is stored in the browser and passed back and forth to the server between requests.

Because the state is stored in the browser, it is vulnerable to front-end manipulation. Without security measures in place, it would not be difficult for a malicous person to manipulate the state of a component in the browser between requests.

In our "counter" example, there are no real negative implications of manipulating something as trivial and ephemeral as the "count" of that component, but in a component with more at stake, for example an "edit post" component with a delete button, security measures need to be in place.

### The Checksum {#the-checksum}

The fundamental security underpinning Livewire is a "checksum" that travels along with request/responses and is used to validate that the state from the server hasn't been tampered with in the browser.

To further explain, consider the "counter" component above. Rather than simply passing <span style="white-space: nowrap">`{ count: 1 }`</span> to the browser, Livewire will generate a hash (checksum) of that payload using a secure key and pass it along with the state.

A more realistic representation of the Livewire payload for the "counter" would look something like this:

@component('components.code', ['lang' => 'js'])
{
    state: { count: 1 },
    checksum: "A6jHn359Ku3lFc82arW8",
}
@endcomponent

Now if a malicous person tampered with the state in the browser between requests, before Livewire handled a component update, it would see that a hash of the payload doesn't match the checksum and throw an error.

### Persistent Middleware {#persistent-middleware}

The second security measure Livewire puts in place is "persistent middleware". This means Livewire will capture any authentication/authorization middleware that was used during the "Initial Request" and re-apply it to subsequent requests.

Without this measure, a Livewire subsequent request could be captured and re-played after a user has been logged out of the application and should no longer have access to those code paths.

By default, Livewire re-applies the out-of-the-box authentication and authorization middlewares that ship with every Laravel app. Here are a couple of the defaults:

@component('components.code', ['lang' => 'php'])
[
    ...
    \Illuminate\Auth\Middleware\Authenticate::class,
    \Illuminate\Auth\Middleware\Authorize::class,
]
@endcomponent

If you wish to add your own middlewares to be captured and re-applied if present, you can do so in your app's service provider with the following API:

@component('components.code', ['lang' => 'php'])
Livewire::addPersistentMiddleware([
    YourOwnMiddleware::class,
]);
@endcomponent

Now any middlewares you added will be re-applied to subsequent Livewire requests IF the middleware is assigned to the original route the component was loaded on.
