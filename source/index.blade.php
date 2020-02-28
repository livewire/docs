@extends('_layouts.master')

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
            It's not like anything you've seen before, the best way to understand it is just to look at the code. Strap on your snorkle, we're diving in.
        </p>
        <p class="-mt-6 text-gray-500 text-xl"><em>...I'll get my floaties</em></p>

        <div class="pt-8 pb-6">
            <p class="font-bold mt-0 mb-2 text-gray-500 text-xs tracking-wider uppercase text-center">Our Lovely Sponsors:</p>
            <a style="min-height: 75px; display: block;" href="https://laravel.com/" target="_blank">
                <img class="w-48 m-auto mb-4" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
            </a>
            <a style="min-height: 75px; display: block;" href="https://intellow.com/" target="_blank">
                <img class="w-48 m-auto mb-4" src="/assets/img/sponsor_intellow.png" alt="Intellow">
            </a>
            <a style="min-height: 75px; display: block;" href="http://jrmerritt.com/" target="_blank">
                <img class="w-48 m-auto mb-4" src="/assets/img/sponsor_jrmerritt.png" alt="Laravel">
            </a>
            <a style="min-height: 75px; display: block;" href="https://trustfactory.bz/" target="_blank">
                <img class="w-48 m-auto mb-4" src="/assets/img/sponsor_trustfactory.png" alt="Laravel">
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

        <p>Here's a real-time search component built with Livewire.</p>

<div>
@codeComponent(['className' => 'App\Http\Livewire\SearchUsers.php', 'viewName' => 'resources/views/livewire/search-users.blade.php']) @slot('class') @verbatim
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
@endverbatim @endslot @endcodeComponent
</div>

        <p>You can include this component anywhere in your app like so.</p>

<div class="">
@codeComponent(['viewName' => 'resources/views/welcome.blade.php']) @slot('view') @verbatim
<body>
    ...
    @livewire('search-users')
    ...
</body>
@endverbatim @endslot @endcodeComponent
</div>

        <p>When a user types into the search input, the list of users updates in real-time.</p>

        <p>Bonkers, I know...</p>

        <h2>How the he*k does this work?</h2>

        <ul>
            <li>Livewire renders the initial component output with the page (like a Blade include), this way it's SEO friendly.</li>
            <li>When an interaction occurs, Livewire makes an AJAX request to the server with the updated data.</li>
            <li>The server re-renders the component and responds with the new HTML.</li>
            <li>Livewire then intelligently mutates DOM according to the things that changed.</li>
        </ul>

        <h2>Some questions you might have...</h2>

        <p style="margin-bottom: 0"><strong>
            Does this use websockets?
        </strong></p>
        <p style="margin-top: .5rem">
            No, Livewire relies solely on AJAX requests to do all its server communication. This means it's as reliable and scalable as your current setup.
        </p>

        <p style="margin-bottom: 0"><strong>
            Is this a Vue-replacement?
        </strong></p>
        <p style="margin-top: .5rem">
            In some ways yes, but mostly for cases where your Vue components are already sending `axios` or `fetch` requests. (Think searching, filtering, forms)
        </p>

        <p style="margin-bottom: 0"><strong>
            If it doesn't replace Vue, what do I do when I need JavaScript, like a drop-down, modal, or datepicker?
        </strong></p>
        <p style="margin-top: .5rem">
            Livewire works beautifully with the AlpineJS framework (It was built for this need). For third-party library integration (something like Select2, Pickaday, or Dropzone.js), Livewire provides APIs to add support for these. Livewire also has a plugin to support using VueJs components inside of your Livewire components.
        </p>

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
