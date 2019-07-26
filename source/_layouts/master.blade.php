@extends ('_layouts.base')

@section('content')
<header class="flex items-center h-24 py-4 bg-white" role="banner">
    <div class="container flex items-center mx-auto px-4 lg:px-8">
        <div class="flex items-center">
            <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                {!! file_get_contents(__DIR__ . "/../source/assets/img/logo.svg") !!}
            </a>
        </div>

        <div class="flex flex-1 justify-end items-center text-right md:pl-10">
            @if ($page->docsearchApiKey && $page->docsearchIndexName)
                @include('_nav.search-input')
            @endif
            <a href="https://github.com/calebporzio/livewire" class="text-blue-800 underline">GitHub</a>
        </div>
    </div>

    @yield('nav-toggle')
</header>
<div class="mb-6" style="
    background-image: url(&quot;data:image/svg+xml;charset=UTF-8,%3csvg width='20px' height='12px' viewBox='0 0 20 12' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3e%3cg id='Artboard' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3e%3cpath d='M20,1 C15,1 15,11 10,11 C5,11 5,1 -1.77635684e-15,1 C-1.77635684e-15,1 -1.77635684e-15,0.666666667 -1.77635684e-15,0 L20,0 C20,0.666666667 20,1 20,1 Z' id='Line-Copy' fill='%23FFFFFF'%3e%3c/path%3e%3c/g%3e%3c/svg%3e&quot;);
    background-repeat-y: no-repeat;
    background-position-y: bottom;
    height: 12px;
"></div>

<main role="main" class="w-full flex-auto">
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
