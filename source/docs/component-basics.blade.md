---
title: Component Basics
description: todo
extends: _layouts.documentation
section: content
---

# Component Basics

## Generating components

It is highly recommended that you use the `php artisan make:livewire` command for all new components.

Here are a few examples of usage:

@code(['lang' => 'bash'])
# Creates Foo.php & foo.blade.php
php artisan make:livewire foo

# Creates FooBar.php & foo-bar.blade.php
php artisan make:livewire foo-bar

# Creates Foo/Bar.php & foo/bar.blade.php
php artisan make:livewire foo.bar
@endcode

## The render() method

The following points are important to know:

* `render()` should return a Blade view (like controllers do)
* There MUST be one root HTML tag for each Livewire Blade view
* `render()` runs every time the component updates

### Returning Blade
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

@codeComponent([
    'className' => 'ShowPosts.php',
    'viewName' => 'show-posts.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all();
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    @foreach ($posts as $post)
        @include('includes.post', $post)
    @endforeach
</div>
@endverbatim
@endslot
@endcodeComponent

@warning
Although `render()` methods closely resemble controller methods, there are a few techniques you are used to using in controllers that aren't available in Livewire components.

Here are some common things you might forget ARE NOT possible in Livewire:
@endwarning

@code(['lang' => 'php'])
@verbatim
public function render()
{
    return redirect()->to('/endpoint');
    // Or
    return back();
    // Or
    return ['some' => 'data'];
}
@endverbatim
@endcode

## Component Properties

Livewire components store and track state using class properties on the Component class. Here's what's important to know:

* Properties MUST be public
* Properties are exposed as plain-text in JavaScript
* Properties MUST be of PHP type: `string`, `numeric`, or `array`

### Automatically Available Inside View

Similar to Jobs or Mailables, properties marked as `public` are automatically made available in the Blade view. For example:

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class HelloWorld extends Component
{
    public $message = 'Hello World';

    public function render()
    {
        // Notice we aren't passing "$message" into the view.
        return view('livewire.hello-world');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <h1>{{ $message }}</h1>
    <!-- "Hello World" -->
</div>
@endverbatim
@endslot
@endcodeComponent

### Initializing Properties

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
    <!-- "Hello Alex" -->
</div>
@endverbatim
@endslot
@endcodeComponent

You can think of `mount()` like you would the `boot()` method of a Laravel Model, or the `created()` method of a Vue component.
