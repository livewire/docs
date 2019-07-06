---
title: Quickstart
description: todo
extends: _layouts.documentation
section: content
---

## Install Livewire

Include the PHP
@code(['lang' => 'bash'])
composer require calebporzio/livewire
@endcode

Include the JavaScript (on every page that will be using Livewire)

@code
@verbatim
    ...
    @livewireAssets
</body>
</html>
@endverbatim
@endcomponent


## Create a component

Run the following command to generate a new Livewire component called `counter`.

@code(['lang' => 'bash'])
php artisan make:livewire counter
@endcode

Running this command will generate the following two files:

@codeComponent([
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')
@verbatim
namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
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
    ...
</div>
@endverbatim
@endslot
@endcodeComponent

Let's add some text to the view so we can see something tangible in the browser.

@codeComponent([
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('view')
@verbatim
<div>
    <h1>Hello World!</h1>
</div>
@endverbatim
@endslot
@endcodeComponent

## Include the component
Think of Livewire components like Blade includes. You can insert `@livewire` anywhere in a Blade view and it will render.

@code(['lineHighlight' => 3])
@verbatim
<body>
    <div>
        @livewire('counter')
    </div>

    @livewireAssets
</body>
</html>
@endverbatim
@endcomponent

## View it in the browser

Now load the page you included Livewire on in the browser. You should see "Hello World!".

## Add "counter" functionality

Replace the generated content of the `counter` component class and view with the following:

@codeComponent([
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')
@verbatim
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
@endverbatim
@endslot
@slot('view')
@verbatim
<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
</div>
@endverbatim
@endslot
@endcodeComponent

## View it in the browser

Now reload the page in the browser, you should see the `counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic.
