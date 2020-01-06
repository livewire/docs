@extends('_layouts.master')

@php
$page->siteName = 'Livewire Documentation';
@endphp

@section('nav-toggle')
    @include('_nav.menu-toggle')
@endsection

@section('content')
@yield('header')

<section class="container mx-auto px-6 md:px-8 py-12 content">
    <div class="flex flex-col-reverse md:flex-row">
        <nav id="js-nav-menu" class="nav-menu hidden lg:block">
            @include('_nav.menu', ['items' => $page->navigation])
        </nav>

        <div class="w-full md:w-4/5 lg:w-3/5 break-words lg:pl-4" v-pre>
            @if (strlen($page->title))
                <h1>{!! $page->title !!}</h1>
            @endif

            @yield('content')

            <div class="mt-12 pt-8 pb-6 border-t-2">
                @include('_nav.footer-links', ['items' => $page->navigation])
            </div>
        </div>

        <div class="flex-col md:block md:w-1/5 lg:pl-12">
            <div>
                <p class="font-bold mt-0 mb-0 text-gray-500 text-xs tracking-wider uppercase md:text-right">Sponsors</p>

                <a class="block mb-4" href="https://intellow.com/" target="_blank">
                    <img class="md:ml-auto w-32" src="/assets/img/sponsor_intellow.png" alt="Livewire Sponsor: Intellow">
                </a>

                <a class="block" href="https://laravel.com/" target="_blank">
                    <img class="md:ml-auto w-32" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
                </a>
            </div>

            <div class="md:pt-8">
                <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CE7D553Y&placement=laravel-livewirecom" id="_carbonads_js"></script>
            </div>
        </div>
    </div>
</section>
@overwrite
