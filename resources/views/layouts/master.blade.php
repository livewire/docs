@extends ('layouts.base')

@section('content')

<header class="relative flex justify-between items-center h-24 py-4 px-4 bg-white" role="banner">
    <div class="flex items-center w-full">
        <div class="flex items-center">
            <a href="/" aria-label="{{ config('app.name') }} home" title="{{ config('app.name') }} home" class="items-center inline-flex">
                {!! file_get_contents(public_path('/img/logo.svg')) !!}
            </a>
        </div>

        <div class="hidden lg:flex items-center justify-end flex-1 text-sm text-right md:pl-10 sm:text-base">
            @if ($docsearchApiKey && $docsearchIndexName)
                @include('includes.search-input')
            @endif
            <a href="/docs/quickstart" class="ml-3 text-blue-800 sm:ml-6">Docs</a>
            <a href="/screencasts" class="ml-3 text-blue-800 sm:ml-6">Screencasts</a>
            <a href="/podcast" class="ml-3 text-blue-800 sm:ml-6">Podcast</a>
            <a href="https://forum.laravel-livewire.com" class="ml-3 text-blue-800 sm:ml-6">Forum</a>
            <a href="https://discord.gg/bWqenqX">
                <svg class="w-6 ml-3 text-blue-800 fill-current sm:w-8 sm:ml-6"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.076 11c.6 0 1.086.45 1.075 1 0 .55-.474 1-1.075 1C9.486 13 9 12.55 9 12s.475-1 1.076-1zm3.848 0c.601 0 1.076.45 1.076 1s-.475 1-1.076 1c-.59 0-1.075-.45-1.075-1s.474-1 1.075-1zm4.967-9C20.054 2 21 2.966 21 4.163V23l-2.211-1.995-1.245-1.176-1.317-1.25.546 1.943H5.109C3.946 20.522 3 19.556 3 18.359V4.163C3 2.966 3.946 2 5.109 2H18.89zm-3.97 13.713c2.273-.073 3.148-1.596 3.148-1.596 0-3.381-1.482-6.122-1.482-6.122-1.48-1.133-2.89-1.102-2.89-1.102l-.144.168c1.749.546 2.561 1.334 2.561 1.334a8.263 8.263 0 0 0-3.096-1.008 8.527 8.527 0 0 0-2.077.02c-.062 0-.114.011-.175.021-.36.032-1.235.168-2.335.662-.38.178-.607.305-.607.305s.854-.83 2.705-1.376l-.103-.126s-1.409-.031-2.89 1.103c0 0-1.481 2.74-1.481 6.121 0 0 .864 1.522 3.137 1.596 0 0 .38-.472.69-.871-1.307-.4-1.8-1.24-1.8-1.24s.102.074.287.179c.01.01.02.021.041.031.031.022.062.032.093.053.257.147.514.262.75.357.422.168.926.336 1.513.452a7.06 7.06 0 0 0 2.664.01 6.666 6.666 0 0 0 1.491-.451c.36-.137.761-.337 1.183-.62 0 0-.514.861-1.862 1.25.309.399.68.85.68.85z"/></svg>
            </a>
            <a href="https://github.com/livewire/livewire">
                <svg class="w-6 ml-3 text-blue-800 fill-current sm:w-8 sm:ml-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>GitHub</title><path d="M10 0a10 10 0 0 0-3.16 19.49c.5.1.68-.22.68-.48l-.01-1.7c-2.78.6-3.37-1.34-3.37-1.34-.46-1.16-1.11-1.47-1.11-1.47-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.9 1.52 2.34 1.08 2.91.83.1-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.94 0-1.1.39-1.99 1.03-2.69a3.6 3.6 0 0 1 .1-2.64s.84-.27 2.75 1.02a9.58 9.58 0 0 1 5 0c1.91-1.3 2.75-1.02 2.75-1.02.55 1.37.2 2.4.1 2.64.64.7 1.03 1.6 1.03 2.69 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85l-.01 2.75c0 .26.18.58.69.48A10 10 0 0 0 10 0"></path></svg>
            </a>
        </div>

        <div
            x-data="{ open: false }"
            x-show="open"
            @@set-nav-open.window="open = $event.detail"
            class="fixed inset-0 z-20" style="background: rgba(0,0,0,0.5); display: none;"
        >
            <div
                x-show.transition.opacity="open"
                class="fixed left-0 top-0 p-6"
            >
                @include('includes.menu-toggle')
            </div>

            <div
                x-show.transition.translate="open"
                @click.away="$dispatch('set-nav-open', false)"
                class="bg-white bottom-0 fixed right-0 top-0 z-10 p-4 w-4/6 overflow-y-auto"
            >
                <div class="flex flex-col pt-4">
                    <a href="/docs/quickstart" class="text-blue-800 mb-4">Docs</a>
                    <a href="/screencasts" class="text-blue-800 mb-4">Screencasts</a>
                    <a href="/podcast" class="text-blue-800 mb-4">Podcast</a>
                    <a href="https://forum.laravel-livewire.com" class="text-blue-800 mb-4">Forum</a>
                    <a href="https://github.com/livewire/livewire" class="text-blue-800">GitHub</a>
                </div>

                <div>
                    <hr class="border-gray-200 mb-0 mt-8">
                    <div class="-ml-8">
                        @yield('nav-menu')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.menu-toggle')

    <div class="absolute bottom-0 left-0 w-full mb-6" style="
        background-image: url(&quot;data:image/svg+xml;charset=UTF-8,%3csvg width='20px' height='12px' viewBox='0 0 20 12' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3e%3cg id='Artboard' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3e%3cpath d='M20,1 C15,1 15,11 10,11 C5,11 5,1 -1.77635684e-15,1 C-1.77635684e-15,1 -1.77635684e-15,0.666666667 -1.77635684e-15,0 L20,0 C20,0.666666667 20,1 20,1 Z' id='Line-Copy' fill='%23FFFFFF'%3e%3c/path%3e%3c/g%3e%3c/svg%3e&quot;);
        background-repeat-y: no-repeat;
        background-position-y: bottom;
        height: 12px;
        margin-bottom: -12px;
    "></div>
</header>

<main role="main" class="flex-auto w-full">
    @yield('content')
</main>
@overwrite

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Animate the Jellyfish logo because why not?
        animate({elements: '#Jelly', transform: ['translateY(0%)', 'translateY(-3%)'], easing: 'in-out-cubic'}).then(() => {
            animate({elements: '#Jelly', transform: ['translateY(-3%)', 'translateY(3%)'], loop: true, direction: 'alternate', easing: 'in-out-cubic', duration: 2000})
        })
    })
</script>
@endpush
