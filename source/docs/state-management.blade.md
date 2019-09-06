---
title: State Management
extends: _layouts.documentation
section: content
---

Livewire components store and track state using class properties on the Component class. Public properties and protected properties serve very different purposes and are treated very differently.

@code(['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    // Public Property
    public $foo;
    // Protected Property
    protected $bar;
@endverbatim
@endcode

Public Properties | Protected Properties
--- | ---
Automatically available inside the component's Blade view (similar to mailables). | Must be passed to Blade view via the `render` method.
Can be used for data-binding (`public $foo;` can be bound via `wire:model="foo"`). | Cannot be referenced by `wire:model`.
Are sent back and forth with every network request (increase network payload). | Are stored in your app's cache between requests (don't increase network payload).
Cannot store sensitive data. (any information stored in them will be visible to JavaScript). | Can store sensitive data (Because data is stored in backend cache).
They MUST be of PHP type: `null`, `string`, `numeric`, or `array` (because JavaScript has to be able to understand them) | Can be any type of data. Including Eloquent models and collections.

@warning
It's common to want to set Eloquent models as public properties. However, this is not what public properties are intended for. It's much better to store them in protected properties.
@endwarning

@warning
Because protected properties are stored in your app's cache between Livewire requests, using a cache driver like `redis` in production is best. Livewire does it's best to garbage collect un-used data, but the more users you have using your app, the more your cache will grow because of Livewire.
@endwarning

### Initializing Properties {#initializing-properties}

Let's say you wanted to make the 'Hello World' message more specific, and greet the currently logged in user. You might try setting the message property to:

@code(['lang' => 'php'])
public $message = 'Hello ' . auth()->user()->first_name;
@endcode

Unfortunately, this is illegal in PHP. However, you can initialize properties at run-time using the `mount` method/hook in Livewire. For example:

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
use Livewire\Component;

class HelloWorld extends Component
{
    public $message;
    protected $user;

    public function mount()
    {
        $this->message = 'Hello ' . auth()->user()->first_name;
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.hello-world', [
            'user' => $this->user,
        ]);
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $message }}</h1>
    <!-- "Hello Alex" -->
    <span>Your last login was on: {{ $user->last_login_at }}</span>
</div>
@endverbatim
@endslot
@endcodeComponent

You can think of `mount()` like you would the `boot()` method of a Laravel Model, or the `created()` method of a Vue component.
