@extends('layouts.master')

@section('nav-menu')
    <div class="ml-8 mt-8">
        @include('includes.screencast-sidebar')
    </div>
@endsection

@section('content')
<section>
    <div class="flex">
        <div class="flex-1">
            @yield('content')
        </div>

        <nav class="hidden lg:block sticky p-8 bg-white w-1/4">
            @include('includes.screencast-sidebar')
        </nav>
    </div>
</section>
@overwrite
