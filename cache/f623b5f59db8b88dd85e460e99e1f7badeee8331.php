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

<div title="Component">
<div title="Component__class">

ShowPosts.php
```php
class ShowPosts extends LivewireComponent
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all();
        ]);
    }
}
```
</div>
<div title="Component__view">

show-posts.blade.php
```html
<div>
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('includes.post', $post, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
```
</div>
</div>

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

<div title="Component">
<div title="Component__class">

HelloWorld.php
```php
class HelloWorld extends LivewireComponent
{
    public $message = 'Hello World';

    public function render()
    {
        // Notice we aren't passing "$message" into the view.
        return view('livewire.hello-world');
    }
}
```
</div>
<div title="Component__view">

hello-world.blade.php
```html
<div>
    <h1><?php echo e($message); ?></h1>
    <!-- "Hello World" -->
</div>
```
</div>
</div>

### Initializing Properties

Let's say you wanted to make the 'Hello World' message more specific, and greet the currently logged in user. You might try setting the message to:

```php
public $message = 'Hello ' . auth()->user()->first_name;
```

Unfortunately, this is illegal in PHP. However, you can initialize properties at run-time using the `mount` method/hook in Livewire. For example:

<div title="Component"><div title="Component__class">

HelloWorld.php
```php
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
```
</div>
<div title="Component__view">

hello-world.blade.php
```html
<div>
    <h1><?php echo e($message); ?></h1>
    <!-- "Hello Alex" -->
</div>
```
</div>
</div>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/5c8f54ab97c5218035723e4658c7e21d070d8bd4.blade.md ENDPATH**/ ?>