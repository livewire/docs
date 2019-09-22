---
title: Quickstart
extends: _layouts.documentation
section: content
---

## Install Livewire

Include the PHP.

<?php $__env->startComponent('_partials.code', ['lang' => 'bash']); ?>
composer require livewire/livewire
<?php echo $__env->renderComponent(); ?>

Include the JavaScript (on every page that will be using Livewire).

<?php $__env->startComponent('_partials.code'); ?>

    ...
    @livewireAssets
</head>
<body>
    ...
</body>
</html>

<?php echo $__env->renderComponent(); ?>

## Create a component {#create-a-component}

Run the following command to generate a new Livewire component called `counter`.

<?php $__env->startComponent('_partials.code', ['lang' => 'bash']); ?>
php artisan make:livewire counter
<?php echo $__env->renderComponent(); ?>

Running this command will generate the following two files:

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public function render()
    {
        return view('livewire.counter');
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    ...
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

Let's add some text to the view so we can see something tangible in the browser.

<?php $__env->startComponent('_partials.tip'); ?>
Livewire components MUST have a single root element.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code-component', [
    'viewName' => 'resources/views/livewire/counter.blade.php',
]); ?>
<?php $__env->slot('view'); ?>

<div>
    <h1>Hello World!</h1>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

## Include the component {#include-the-component}
Think of Livewire components like Blade includes. You can insert `@livewire` anywhere in a Blade view and it will render.

<?php $__env->startComponent('_partials.code', ['lineHighlight' => 6]); ?>

<head>
    ...
    @livewireAssets
</head>
<body>
    @livewire('counter')
</body>
</html>

<?php echo $__env->renderComponent(); ?>

## View it in the browser {#view-in-browser}

Load the page you included Livewire on in the browser. You should see "Hello World!".

## Add "counter" functionality {#add-counter}

Replace the generated content of the `counter` component class and view with the following:

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

## View it in the browser {#view-in-browser-finally}

Now reload the page in the browser, you should see the `counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic 🧙‍♂.️
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/db2306db44fa5b2b3e2c05e262d1863e8005b89c.blade.md ENDPATH**/ ?>