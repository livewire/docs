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
            @livewire('screencast-player', ['screencast' => $screencast])
        </div>

        <nav class="hidden w-1/4 lg:block overflow-hidden bg-white">
            <div class="relative overflow-y-auto max-h-screen invisible hover:visible">
                <div class="p-8 visible bg-white">
                    @include('includes.screencast-sidebar')
                </div>
            </div>
        </nav>
    </div>
</section>
@overwrite
