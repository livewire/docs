@include('includes.screencast-cta')

## Install Livewire

Include the PHP.

@component('components.code', ['lang' => 'shell'])
composer require livewire/livewire
@endcomponent

Include the JavaScript (on every page that will be using Livewire).

@component('components.code', ['lang' => 'blade'])
@verbatim
    ...
    @livewireStyles
</head>
<body>
    ...

    @livewireScripts
</body>
</html>
@endverbatim
@endcomponent

## Create a component {#create-a-component}

Run the following command to generate a new Livewire component called `counter`.

@component('components.code', ['lang' => 'shell'])
php artisan make:livewire counter
@endcomponent

Running this command will generate the following two files:

@component('components.code-component', [
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
@endcomponent

Let's add some text to the view so we can see something tangible in the browser.

@component('components.tip')
Livewire components MUST have a single root element.
@endcomponent

@component('components.code-component', [
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('view')
@verbatim
<div>
    <h1>Hello World!</h1>
</div>
@endverbatim
@endslot
@endcomponent

## Include the component {#include-the-component}
@verbatim
Think of Livewire components like Blade includes. You can insert `<livewire:some-component />` anywhere in a Blade view and it will render.
@endverbatim

@component('components.code', ['lang' => 'blade'])
@verbatim
<head>
    ...
    @livewireStyles
</head>
<body>
    <livewire:counter /> {{-- [tl! highlight] --}}

    ...

    @livewireScripts
</body>
</html>
@endverbatim
@endcomponent

## View it in the browser {#view-in-browser}

Load the page you included Livewire on in the browser. You should see "Hello World!".

## Add "counter" functionality {#add-counter}

Replace the generated content of the `counter` component class and view with the following:

@component('components.code-component', [
    'className' => 'app/Http/Livewire/Counter.php',
    'viewName' => 'resources/views/livewire/counter.blade.php',
])
@slot('class')
@verbatim
class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
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
</div>
@endverbatim
@endslot
@endcomponent

## View it in the browser {#view-in-browser-finally}

Now reload the page in the browser, you should see the `counter` component rendered. If you click the "+" button, the page should automatically update without a page reload. Magic 🧙‍♂.️

@component('components.tip')
In general, something as trivial as this "counter" is more suited for something like AlpineJS, however it's one of the best ways to easily understand the way Livewire works.
@endcomponent
