@extends('layouts.master')

@section('content')
<div class="bg-white">
    <div style="max-width: 600px; margin: auto" class="pt-16 pb-16 px-12 text-2xl">
        <p>
            <strong class="underline">Building modern web apps is hard.</strong>
            Tools like Vue and React are extremely powerful, but the complexity they add to a full-stack developer's workflow is insane.
            <br>
            <strong>It doesn’t have to be this way...</strong>
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Ok, I'm listening...</em></p>
        <p>
            Say hello to <strong>Livewire.</strong>
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Hi Livewire!</em></p>
        <p>
            Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>Consider my interest piqued</em></p>
        <p>
            It's not like anything you've seen before. The best way to understand it is to just look at the code. Strap on your snorkel, we're diving in.
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>...I'll get my floaties</em></p>

        <div class="md:-mx-24 pt-8 pb-6">
            <p class="font-bold mt-0 mb-2 text-gray-500 text-xs tracking-wider uppercase text-center">Our Lovely Sponsors:</p>

            <div class="flex flex-wrap items-center justify-center">
                <a class="mb-4 pr-0 sm:pr-12 block" href="https://laravel.com/" target="_blank">
                    <img class="w-48 m-auto mb-4" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
                </a>
                <a class="mb-4 pr-0 sm:pr-12 block" href="https://devsquad.com/" target="_blank">
                    <img class="w-48 m-auto mb-4" src="/img/sponsor_devsquad.png" alt="DevSquad">
                </a>
                <a class="mb-4 block" href="https://www.livemessage.io/" target="_blank">
                    <img class="w-48 m-auto mb-4" src="/img/sponsor_livemessage.png" alt="Livemessage">
                </a>
            </div>

            <div class="flex flex-wrap items-center justify-around space-x-3 lg:space-x-6 lg:-mx-24">
                <a class="mb-4 block" href="https://padmission.com/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_padmission.png" alt="Padmission">
                </a>

                <a class="mb-4 block" href="https://cierra.de" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_cierra.png" alt="Cierra">
                </a>

                <a class="mb-4 block" href="https://ueberdosis.io" target="_blank">
                    <img class="w-32 m-auto mb-4" src="https://drop.hanspagel.com/xCzFrLeC9d.svg" alt="Uberdosis">
                </a>

                <a class="mb-4 block" href="https://www.1043labs.com/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_1043labs.png" alt="1043 Labs">
                </a>

                <a class="mb-4 block" href="http://jrmerritt.com/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_jrmerritt.png" alt="JR Merritt">
                </a>

                <a class="mb-4 block" href="https://trustfactory.bz/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_trustfactory.png" alt="Trust Factory">
                </a>

                <a class="mb-4 block" href="https://roasted.dev/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_roasted.svg" alt="Roasted Dev">
                </a>

                <a class="mb-4 block" href="https://www.amezmo.com/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_amezmo.svg" alt="Amezmo">
                </a>
                <a class="mb-4 block" href="https://www.snapshooter.io/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor-snapshooter.svg" alt="SnapShooter Backups">
                </a>
                <a class="mb-4 block" href="https://codecourse.com/" target="_blank">
                    <img class="w-32 m-auto mb-4" src="/img/sponsor_codecourse.svg" alt="Codecourse">
                </a>
            </div>
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
        <img src="/img/underwater_jelly.svg">
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

        <p>Here's a real-time search component built with Livewire.</p>

<div>
@component('components.code-component', ['className' => 'App\Http\Livewire\SearchUsers.php', 'viewName' => 'resources/views/livewire/search-users.blade.php']) @slot('class') @verbatim
use Livewire\Component;

class SearchUsers extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search-users', [
            'users' => User::where('username', $this->search)->get(),
        ]);
    }
}
@endverbatim @endslot

@slot('view') @verbatim
<div>
    <input wire:model="search" type="text" placeholder="Search users..."/>

    <ul>
        @foreach($users as $user)
            <li>{{ $user->username }}</li>
        @endforeach
    </ul>
</div>
@endverbatim @endslot @endcomponent
</div>

        <p>You can include this component anywhere in your app like so.</p>

<div class="">
@component('components.code-component', ['viewName' => 'resources/views/welcome.blade.php']) @slot('view') @verbatim
<body>
    ...
    @livewire('search-users')
    ...
</body>
@endverbatim @endslot @endcomponent
</div>

        <p>When a user types into the search input, the list of users updates in real-time.</p>

        <p>Bonkers, I know...</p>

        <h2>How the he*k does this work?</h2>

        <ul>
            <li>Livewire renders the initial component output with the page (like a Blade include). This way, it's SEO friendly.</li>
            <li>When an interaction occurs, Livewire makes an AJAX request to the server with the updated data.</li>
            <li>The server re-renders the component and responds with the new HTML.</li>
            <li>Livewire then intelligently mutates DOM according to the things that changed.</li>
        </ul>

        <hr>

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
