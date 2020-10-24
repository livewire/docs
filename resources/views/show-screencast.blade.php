@extends('layouts.screencasts')

@section('nav-menu')
    <div class="ml-8 mt-8">
        @include('includes.screencast-sidebar')
    </div>
@endsection

@section('content')
    <section class="flex flex-1 h-full">
        <div class="flex-1 overflow-y-auto">
            @livewire('screencast-player', ['screencast' => $screencast])
        </div>

        <nav class="hidden w-1/4 overflow-y-auto bg-white lg:block">
            <div class="relative overflow-y-auto invisible hover:visible">
                <div class="p-8 visible bg-white">
                    @include('includes.screencast-sidebar')
                </div>
            </div>
        </nav>
    </section>
@overwrite
