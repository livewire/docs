---
title: Component Basics
description: todo
extends: _layouts.documentation
section: content
---

## The render() method

There are two things to know:

1) It should return a plain-old Blade view
2) It runs every time the component updates

### Returning Blade
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

@codeComponent([
    'className' => 'ShowPosts.php',
    'viewName' => 'show-posts.blade.php',
])
@slot('class')
@verbatim
class ShowPosts extends LivewireComponent
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

<div title="Warning"><div title="Warning__content">

Although `render()` methods closely resemble controller methods, there are a few techniques you are used to using in controllers that aren't available in Livewire components.

Here are some common things you might forget ARE NOT possible in Livewire:

```php
public function render()
{
    return redirect()->to('/endpoint');
    // Or
    return back();
    // Or
    return ['some' => 'data'];
}
```
</div></div>

<div title="Warning"><div title="Warning__content">

A component's view should contain only one root tag.
</div></div>

## Component Properties

Livewire components store and track state using class properties on the Component class. Here's what's important to know:

* Properties MUST be public
* Properties are exposed as plain-text in JavaScript
* Properties MUST be of PHP type: `string`, `numeric`, or `array`

### Automatically Available Inside View

Properties marked as `public` are automatically made available in the Blade view. For example:

@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
@verbatim
class HelloWorld extends LivewireComponent
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

Let's say you wanted to make the 'Hello World' message more specific, and greet the currently logged in user. You might try setting the message to:

```php
public $message = 'Hello ' . auth()->user()->first_name;
```

Unfortunately, this is illegal in PHP. However, you can initialize properties at run-time using the `mount` method/hook in Livewire. For example:


@codeComponent([
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
])
@slot('class')
@verbatim
class HelloWorld extends LivewireComponent
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
@endverbatim
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
