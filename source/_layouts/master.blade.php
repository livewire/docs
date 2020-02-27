@extends ('_layouts.base')

@section('content')
<header class="relative flex items-center h-24 py-4 bg-white" role="banner">
    <div class="container flex items-center px-4 mx-auto lg:px-8">
        <div class="flex items-center">
            <!-- Desktop Logo -->
            <a href="/" title="{{ $page->siteName }} home" class="items-center hidden md:inline-flex">
                {!! file_get_contents(__DIR__ . "/../source/assets/img/logo.svg") !!}
            </a>
            <!-- Mobile Logo -->
            <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center md:hidden">
                {!! file_get_contents(__DIR__ . "/../source/assets/img/logo-small.svg") !!}
            </a>
        </div>

        <div class="flex items-center justify-end flex-1 text-sm text-right md:pl-10 sm:text-base">
            @if ($page->docsearchApiKey && $page->docsearchIndexName)
                @include('_nav.search-input')
            @endif
            <a href="/docs/quickstart" class="ml-3 text-blue-800 sm:ml-6">Docs</a>
            <a href="https://forum.laravel-livewire.com" class="ml-3 text-blue-800 sm:ml-6">Forum</a>
            <a href="/podcast" class="ml-3 text-blue-800 sm:ml-6">Podcast</a>
            <a href="https://github.com/livewire/livewire">
                <svg class="w-6 ml-3 text-blue-800 fill-current sm:w-8 sm:ml-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>GitHub</title><path d="M10 0a10 10 0 0 0-3.16 19.49c.5.1.68-.22.68-.48l-.01-1.7c-2.78.6-3.37-1.34-3.37-1.34-.46-1.16-1.11-1.47-1.11-1.47-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.9 1.52 2.34 1.08 2.91.83.1-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.94 0-1.1.39-1.99 1.03-2.69a3.6 3.6 0 0 1 .1-2.64s.84-.27 2.75 1.02a9.58 9.58 0 0 1 5 0c1.91-1.3 2.75-1.02 2.75-1.02.55 1.37.2 2.4.1 2.64.64.7 1.03 1.6 1.03 2.69 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85l-.01 2.75c0 .26.18.58.69.48A10 10 0 0 0 10 0"></path></svg>
            </a>
        </div>
    </div>

    @yield('nav-toggle')

    <div class="absolute bottom-0 w-full mb-6" style="
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
