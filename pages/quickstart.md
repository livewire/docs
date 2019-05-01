# Quickstart

## Install Livewire

*Include the PHP*
```bash
> composer require calebporzio/livewire
```

*Include the JavaScript*
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
> php artisan make:livewire Counter
```

Running this command will generate the following two files:

<div title="Component">
<div title="Component__class">

app/Http/Livewire/Counter.php
```php
<?php

namespace App\Http\Livewire;

use Livewire\LivewireComponent;

class Counter extends LivewireComponent
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
    {{-- Go effing nuts. --}}
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

## Register the component

Register the component inside a service provider like so:

<div title="Component">
<div title="Component__class">

app/Providers/AppServiceProvider.php
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('counter', \App\Http\Livewire\Counter::class);
    }
}
```
</div>
</div>

## Inlude the component
Livewire components are included into Blade views just like Blade includes or components. You can include the `@livewire` blade directive wherever you want the component to render.

<div title="Component">
<div title="Component__class">

resources/views/welcome.blade.php
```php
    <!-- Render the Livewire component. -->
    @livewire('counter')

    {!! Livewire::scripts() !!}
</body>
</html>
```
</div>
</div>

## View it in the browser

Now load the page you included Livewire on in the browser. You should see "Hello World!". You should see the `Counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic.

## Add "counter" functionality

To add "counting" functionality, replace the generated content of your `Counter` component and view with the following:

<div title="Component"><div title="Component__class">

Counter.php
```php
class Counter extends LivewireComponent
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

Now reload the page in the browser, you should see the `Counter` component rendered. If you click the "+" or "-" button, the page should automatically update without a page reload. Magic.
