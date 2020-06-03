@extends('layouts.master')

@section('nav-menu')
    <nav class="nav-menu">
        @include('includes.menu', ['items' => $pages->all()])
    </nav>
@endsection

@section('content')
@yield('header')

<section class="container px-6 py-12 mx-auto md:px-8">
    <div class="flex flex-col lg:flex-row">
        <nav class="nav-menu hidden lg:block">
            @include('includes.menu', ['items' => $pages->all()])
        </nav>

        <div class="w-full break-words md:w-4/5 lg:w-3/5 lg:pl-4 content" v-pre>
            <h1>{!! $title !!}</h1>

            @yield('content')

            <div class="pt-8 pb-6 mt-12 border-t-2">
                @include('includes.footer-links')
            </div>
        </div>

        <div class="flex-col md:block mx-auto md:w-1/5 lg:pl-12">
            <div>
                <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CE7D553Y&placement=laravel-livewirecom" id="_carbonads_js"></script>
            </div>

            <div class="flex flex-col justify-center md:pt-8 sm:block">
                <p class="hidden mt-0 mb-4 text-xs font-bold tracking-wider text-gray-500 uppercase sm:block md:text-right">Sponsors</p>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://laravel.com/" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://devsquad.com/" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_devsquad.png" alt="DevSquad">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://intellow.com/" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_intellow.png" alt="Intellow">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://cierra.de" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_cierra.png" alt="Cierra">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="https://www.1043labs.com/" target="_blank">
                    <img class="w-24 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_1043labs.png" alt="1043 Labs">
                </a>

                <a style="height: 50px" class="block pb-3 mb-3" href="http://jrmerritt.com/" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_jrmerritt.png" alt="JR Merritt">
                </a>

                <a class="block" href="https://trustfactory.bz/" target="_blank">
                    <img class="w-32 mx-auto md:mx-0 md:ml-auto" src="/img/sponsor_trustfactory.png" alt="Trustfactory">
                </a>
            </div>
        </div>
    </div>
</section>
@overwrite
