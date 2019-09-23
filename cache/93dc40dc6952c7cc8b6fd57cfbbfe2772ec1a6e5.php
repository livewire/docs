---
title: State Management
extends: _layouts.documentation
section: content
---

Livewire components store and track state using class properties on the Component class. Public properties and protected properties serve very different purposes and are treated very differently.

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

class FooComponent extends Component
{
    // Public Property
    public $foo;
    // Protected Property
    protected $bar;

<?php echo $__env->renderComponent(); ?>

Public Properties | Protected Properties
--- | ---
Automatically available inside the component's Blade view (similar to mailables). | Must be passed to Blade view via the `render` method.
Can be used for data-binding (`public $foo;` can be bound via `wire:model="foo"`). | Cannot be referenced by `wire:model`.
Are sent back and forth with every network request (increase network payload). | Are stored in your app's cache between requests (don't increase network payload).
Cannot store sensitive data. (any information stored in them will be visible to JavaScript). | Can store sensitive data (Because data is stored in backend cache).
They MUST be of PHP type: `null`, `string`, `numeric`, `boolean`, or `array` (because JavaScript has to be able to understand them) | Can be any type of data. Including Eloquent models and collections.

<?php $__env->startComponent('_partials.warning'); ?>
It's common to want to set Eloquent models as public properties. However, this is not what public properties are intended for. It's much better to store them in protected properties.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.warning'); ?>
Because protected properties are stored in your app's cache between Livewire requests, using a cache driver like `redis` in production is best. Livewire does it's best to garbage collect un-used data, but the more users you have using your app, the more your cache will grow because of Livewire.
<?php echo $__env->renderComponent(); ?>

### Initializing Properties {#initializing-properties}

Let's say you wanted to make the 'Hello World' message more specific, and greet the currently logged in user. You might try setting the message property to:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
public $message = 'Hello ' . auth()->user()->first_name;
<?php echo $__env->renderComponent(); ?>

Unfortunately, this is illegal in PHP. However, you can initialize properties at run-time using the `mount` method/hook in Livewire. For example:

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'HelloWorld.php',
    'viewName' => 'hello-world.blade.php',
]); ?>
<?php $__env->slot('class'); ?>
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
<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    <h1>{{ $message }}</h1>
    <!-- "Hello Alex" -->
    <span>Your last login was on: {{ $user->last_login_at }}</span>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

You can think of `mount()` like you would the `boot()` method of a Laravel Model, or the `created()` method of a Vue component.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/df4701bbd3e79ad6e25737d205c6261108506778.blade.md ENDPATH**/ ?>