@extends('_layouts.master')

@php
$page->siteName = 'Livewire Documentation';
@endphp

@section('nav-toggle')
    @include('_nav.menu-toggle')
@endsection

@section('content')
@yield('header')

<section class="container px-6 py-12 mx-auto md:px-8 content">
    <div class="flex flex-col lg:flex-row">
        <nav
            class="nav-menu lg:block"
            :class="mobileMenuVisible ? 'block' : 'hidden'"
        >
            @include('_nav.menu', ['items' => $page->navigation])
        </nav>

        <div class="w-full break-words md:w-4/5 lg:w-3/5 lg:pl-4" v-pre>
            @if (strlen($page->title))
                <h1>{!! $page->title !!}</h1>
            @endif

            @yield('content')

            <div class="pt-8 pb-6 mt-12 border-t-2">
                @include('_nav.footer-links', ['items' => $page->navigation])
            </div>
        </div>

        <div class="flex-col md:block md:w-1/5 lg:pl-12">
            <div>
                <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CE7D553Y&placement=laravel-livewirecom" id="_carbonads_js"></script>
            </div>

            <div class="flex flex-wrap justify-around md:pt-8 sm:block">
                <p class="hidden mt-0 mb-4 text-xs font-bold tracking-wider text-gray-500 uppercase sm:block md:text-right">Sponsors</p>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://laravel.com/" target="_blank">
                    <img class="w-32 md:ml-auto" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://intellow.com/" target="_blank">
                    <img class="w-32 md:ml-auto" src="/assets/img/sponsor_intellow.png" alt="Intellow">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://cierra.de" target="_blank">
                    <img class="w-32 md:ml-auto" src="/assets/img/sponsor_cierra.png" alt="Cierra">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="http://jrmerritt.com/" target="_blank">
                    <img class="w-32 md:ml-auto" src="/assets/img/sponsor_jrmerritt.png" alt="JR Merritt">
                </a>

                <a class="block" href="https://trustfactory.bz/" target="_blank">
                    <img class="w-32 md:ml-auto" src="/assets/img/sponsor_trustfactory.png" alt="Trustfactory">
                </a>
            </div>
        </div>
    </div>
</section>
@overwrite
