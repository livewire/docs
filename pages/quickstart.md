# Quickstart

## Install Livewire

*Include the PHP*
```bash
composer require calebporzio/livewire
```

*Include the JavaScript (on every page that will be using Livewire)*
<div title="Component"><div title="Component__class"><div char="fade">

```html
    ...
```
</div>

```php
    {!! Livewire::scripts() !!}
```
<div char="fade">

```html
</body>
</html>
```
</div></div></div>

## Create a component

Run the following command to generate a new Livewire component called `Counter` and it's corresponding Blade view.

```bash
php artisan make:livewire counter
```

Running this command will generate the following two files:

<div title="Component">
<div title="Component__class">

app/Http/Livewire/Counter.php
```php
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
```
</div>
<div title="Component__view">

resources/views/livewire/counter.blade.php
```html
<div>
    ...
</div>
```
</div>
</div>

Let's replace the Livewire view with some text so we can see something tangible in the browser.

<div title="Component">
<div title="Component__view">

resources/views/livewire/counter.blade.php
```html
<div>
    <h1>Hello World!</h1>
</div>
```
</div>
</div>

## Include the component
Think of Livewire components like you would Blade includes. You can include the `@livewire` blade directive wherever you want the component to render.

<div title="Component">
<div title="Component__class">

```php
    <div>
        @livewire('counter')
    </div>
```
<div char="fade">

```php

    {!! Livewire::scripts() !!}
</body>
</html>
```
</div>
</div>
</div>

## View it in the browser

Now load the page you included Livewire on in the browser. You should see "Hello World!".

## Add "counter" functionality

Replace the generated content of the `counter` component class and view with the following:

<div title="Component"><div title="Component__class">

Counter.php
```php
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
```
</div><div title="Component__view">

counter.blade.php
```html
<div style="text-align: center">

    <button wire:click="increment">+</button>

    <h1>{{ $count }}</h1>

    <button wire:click="decrement">-</button>

</div>
```
</div></div>

## View it in the browser

Now reload the page in the browser, you should see the `counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic.
