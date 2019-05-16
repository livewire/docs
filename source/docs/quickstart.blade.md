---
title: Quickstart
description: todo
extends: _layouts.documentation
section: content
---
## Install Livewire

*Include the PHP*
```bash
composer require calebporzio/livewire
```


*Include the JavaScript (on every page that will be using Livewire)*

@component('_partials.code', ['lang' => 'html'])@verbatim
    ...
    {!! Livewire::scripts() !!}
</body>
</html>
@endverbatim@endcomponent


## Create a component

Run the following command to generate a new Livewire component called `counter`.

```bash
php artisan make:livewire counter
```

Running this command will generate the following two files:

@component('_partials.code', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')@verbatim
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public function render()
    {
        return view('livewire.counter');
    }
}
@endverbatim@endslot
@slot('view')@verbatim
<div>
    ...
</div>
@endverbatim@endslot@endcomponent

Let's add some text to the view so we can see something tangible in the browser.

@component('_partials.code', [
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('view')@verbatim
<div>
    <h1>Hello World!</h1>
</div>
@endverbatim@endslot@endcomponent

## Include the component
Think of Livewire components like Blade includes. You can insert `@livewire` anywhere in a Blade view and it will render.

@component('_partials.code')@verbatim
    <div>
        @livewire('counter')
    </div>

    {!! Livewire::scripts() !!}
</body>
</html>
@endverbatim@endcomponent

## View it in the browser

Now load the page you included Livewire on in the browser. You should see "Hello World!".

## Add "counter" functionality

Replace the generated content of the `counter` component class and view with the following:

@component('_partials.code', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')@verbatim
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
@endverbatim@endslot
@slot('view')@verbatim
<div style="text-align: center">

    <button wire:click="increment">+</button>

    <h1>{{ $count }}</h1>

    <button wire:click="decrement">-</button>

</div>
@endverbatim@endslot@endcomponent

## View it in the browser

Now reload the page in the browser, you should see the `counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic.
