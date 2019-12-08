---
title: State Management
extends: _layouts.documentation
section: content
---

Livewire components store and track state using public class properties on the Component class.

@code(['lang' => 'php'])
@verbatim
class FooComponent extends Component
{
    // Public Property
    public $foo;
@endverbatim
@endcode

Here are some helpful points about public properties in Livewire.

@table
Public Properties |
--- |
Automatically available inside the component's Blade view (similar to mailables). |
Can be used for data-binding (`public $foo;` can be bound via `wire:model="foo"`). |
Are sent back and forth with every network request (increase network payload). |
Cannot store sensitive data. (any information stored in them will be visible to JavaScript). |
They MUST be of PHP type: `null`, `string`, `numeric`, `boolean`, or `array` (because JavaScript has to be able to understand them) |
@endtable

@warning
It's common to want to set Eloquent models as public properties. However, this is not what public properties are intended for. It's much better to store the model's ID and fetch it from the database in the places you need it.
@endwarning

### Initializing Properties {#initializing-properties}

Let's say you wanted to make the 'Hello World' message more specific, and greet the currently logged in user. You might try setting the message property to:

@code(['lang' => 'php'])
public $message = 'Hello ' . auth()->user()->first_name;
@endcode

Unfortunately, this is invalid PHP (you can't assign the result of an expression to a property directly). However, you can initialize properties using the `mount` method/hook in Livewire. For example:

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
use Livewire\Component;

class HelloWorld extends Component
{
    public $message;

    public function mount()
    {
        $this->message = 'Hello ' . auth()->user()->first_name;
    }

    public function render()
    {
        return view('livewire.hello-world');
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $message }}</h1>
</div>
@endverbatim
@endslot
@endcodeComponent

You can think of `mount()` like you would the `boot()` method of a Laravel Model, or the `created()` method of a Vue component.

### Storing/Referencing Eloquent Models {#storing-eloquent-models}

As mentioned earlier, it is common to want to set an Eloquent model (like `App\User`) as a public property (`public $user`), HOWEVER, this is not allowed. Public properties can only be set as non-object values (arrays, integers, strings, booleans).

Here's the best way to deal with Eloquent model's inside a Livewire component.

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
use Livewire\Component;

class ShowUser extends Component
{
    public $userId;

    public function mount($user)
    {
        $this->userId = $user->id;
    }

    public function getUserProperty()
    {
        return \App\User::findOrFail($this->userId);
    }

    public function executeSomeActionOnTheUser()
    {
        $this->user->someAction();
    }

    public function render()
    {
        return view('livewire.show-user', [
            'user' => $this->user,
        ]);
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <h1>Hi {{ $user->name }}!</h1>

    <button type="button" wire:click="executeSomeActionOnTheUser">Do Something</button>
</div>
@endverbatim
@endslot
@endcodeComponent
