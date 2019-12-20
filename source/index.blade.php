@extends('_layouts.master')

@section('content')
<div class="bg-white">
    <div style="max-width: 600px; margin: auto" class="pt-16 pb-16 px-12 text-2xl">
        <p>
            <strong class="underline">JavaScript is crazy these days.</strong> We pull heaps of code and complexity into a project for simple things like modals and loading spinners. <strong>It doesn’t have to be this way...</strong>
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Ok, I'm listening...</em></p>
        <p>
            Say hello to <strong>Livewire.</strong>
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Hi Livewire!</em></p>
        <p>
            Livewire is a full-stack framework for Laravel that makes building dynamic front-ends as simple as writing vanilla PHP (literally).
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Consider my interest piqued</em></p>
        <p>
            It's not like anything you've seen before, the best way to understand it is just to look at the code. Strap on your snorkle, we're diving in.
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>...I'll get my floaties</em></p>

        <div class="py-6">
            <p class="font-bold mt-0 mb-2 text-gray-500 text-xs tracking-wider uppercase text-center">Sponsored By:</p>
            <a href="https://intellow.com/" target="_blank">
                <img class="w-48 m-auto" src="/assets/img/sponsor_intellow.png" alt="Livewire Sponsor: Intellow">
            </a>
        </div>

        <div class="md:-mx-12 pt-8">
            <script async data-uid="7305ce6747" src="https://f.convertkit.com/7305ce6747/4f6b8fb1d8.js"></script>
        </div>
    </div>
</div>

<div class="mb-6" style="
    background-image: url(&quot;data:image/svg+xml;charset=UTF-8,%3csvg width='20px' height='12px' viewBox='0 0 20 12' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3e%3cg id='Artboard' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3e%3cpath d='M20,1 C15,1 15,11 10,11 C5,11 5,1 -1.77635684e-15,1 C-1.77635684e-15,1 -1.77635684e-15,0.666666667 -1.77635684e-15,0 L20,0 C20,0.666666667 20,1 20,1 Z' id='Line-Copy' fill='%23FFFFFF'%3e%3c/path%3e%3c/g%3e%3c/svg%3e&quot;);
    background-repeat-y: no-repeat;
    background-position-y: bottom;
    height: 12px;
"></div>

<div class="">
    <div class="absolute right-0 pt-6 pr-12 xl:pr-16 hidden lg:block" id="underwater-jelly">
        <img src="/assets/img/underwater_jelly.svg">
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the Jellyfish logo because why not?
            animate({
                elements: '#underwater-jelly',
                transform: ['translateY(0%)', 'translateY(-3%)'],
                easing: 'in-out-cubic'
            }).then(() => {
                animate({
                    elements: '#underwater-jelly',
                    transform: ['translateY(-3%)', 'translateY(3%)'],
                    loop: true,
                    direction: 'alternate',
                    easing: 'in-out-cubic',
                    duration: 2000
                })
            })
        })
    </script>

    <div style="max-width: 800px; margin: auto" class="px-12 pt-12 pb-16 text-xl">
        <h2>Ok, let's see some code</h2>

        <p>Consider the following "counter" component written in VueJs:</p>

        <div class="">
@code(['lang' => 'javascript']) @verbatim
<script>
    export default {
        data: {
            count: 0
        },
        methods: {
            increment() {
                this.count++
            },
            decrement() {
                this.count--
            },
        },
    }
</script>

<template>
    <div>
        <button @click="increment">+</button>
        <button @click="decrement">-</button>

        <span>{{ count }}</span>
    </div>
</template>
@endverbatim @endcode
        </div>

        <p>Now, let's see how we would accomplish the exact same thing with a Livewire component.</p>

        <div class="">
@codeComponent(['className' => 'App\Http\Livewire\Counter.php', 'viewName' => 'resources/views/livewire/counter.blade.php']) @slot('class') @verbatim
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
@endverbatim @endslot

@slot('view') @verbatim
<div>
    <button wire:click="increment">+</button>
    <button wire:click="decrement">-</button>

    <span>{{ $this->count }}</span>
</div>
@endverbatim @endslot @endcodeComponent
        </div>

        <p>Are you still with me? I know, it's bonkers, but just go with it for now.</p>

        <h2>How the he*k does this work?</h2>

        <p>Livewire's not that different from frameworks like Vue/React actually. Here's what happens when you click the "+" button in the Vue component:</p>

        <ol>
            <li>Vue hears the click because of <code>@verbatim @click="increment" @endverbatim</code></li>
            <li>Vue calls the <code>increment</code> method, which updates <code>count</code></li>
            <li>Vue re-renders the template and updates the DOM</li>
        </ol>

        <p>Livewire works nearly the same, but with 2 extra steps behind the scenes.</p>

        <ol>
            <li>Livewire hears the click because of <code>@verbatim wire:click="increment" @endverbatim</code></li>
            <li><strong>Livewire sends an ajax request to PHP</strong></li>
            <li>PHP calls the <code>increment</code> method, which updates <code>$count</code></li>
            <li><strong>PHP re-renders the Blade template and sends back the HTML</strong></li>
            <li>Livewire receives the response, and updates the DOM</li>
        </ol>

        <p>Cool huh?</p>

        <h2>Can I replace all my Vue components with Livewire components now?</h2>

        <p>Not exactly. Livewire will hopefully replace a bunch of them, but because every interaction requires a roundtrip to the server, it's better to use JavaScript for things that need to be instant (like animations, or toggling a dropdown).</p>

        <p>A good rule of thumb is: any JavaScript components that rely on ajax for server communication, will be better off as Livewire components. There's lots of other good use cases, but this gives you a basic idea of where to start.</p>

        <h2>When can I use it in my projects?</h2>

        <p>Right now, the project is still in pre-release. Sign up for my email newsletter to get notified when It's ready for prime-time.</p>

        <style>
            .formkit-form[data-uid="2e197490cb"][min-width~="700"] [data-style="clean"],
            .formkit-form[data-uid="2e197490cb"][min-width~="800"] [data-style="clean"] {
                padding: 0 !important;
            }
        </style>
        <script async data-uid="2e197490cb" src="https://f.convertkit.com/2e197490cb/2cb7ff8b4c.js"></script>
    </div>
</div>
@endsection
