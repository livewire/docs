@extends('layouts.master')

@section('content')
<div class="relative" style="background: #1086CB; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3));">
    <div class="container mx-auto px-12 pt-12 text-xl flex-col md:flex-row flex justify-between relative items-center" style="max-width: 900px">
        @if ($screencast->prev)
            <a href="/screencasts/{{ $screencast->prev->slug }}" class="hidden lg:block w-32 mr-4 text-blue-400 hover:text-blue-100">
                {!! file_get_contents(public_path('/img/arrow-previous.svg')) !!}
            </a>
        @else
            <div class="hidden lg:block w-32 mr-4"></div>
        @endif
        <div class="pb-16 pt-6" x-data>
            <div class="rounded overflow-hidden shadow-xl">
                <div style="padding:56.25% 0 0 0;position:relative;">
                    <iframe src="{{ $screencast->url }}?autoplay=1" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </div>
                <div class="p-4" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.23));">
                    <span class="block border-b border-blue-700 font-bold font-display mb-0 mb-3 text-2xl text-white">{{ $screencast->title }}</span>
                    <span class="block leading-5 text-blue-200 text-sm tracking-normal">{{ $screencast->description }}</span>
                </div>
            </div>
        </div>
        @if ($screencast->next)
            <a href="/screencasts/{{ $screencast->next->slug }}" class="hidden lg:block w-32 ml-4 text-blue-400 hover:text-blue-100">
                {!! file_get_contents(public_path('/img/arrow-next.svg')) !!}
            </a>
        @else
            <div class="hidden lg:block w-32 ml-4"></div>
        @endif
    </div>

    <div class="hidden lg:block absolute bottom-0 right-0 pr-12">
        <img class="w-48 pt-8" src="/img/screencast-head.png" alt="Building Livewire Podcast Logo">
    </div>
</div>

@include('includes.screencast-list', ['activeScreencast' => $screencast])
@overwrite

@push('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
var iframe = document.querySelector('iframe');
var player = new Vimeo.Player(iframe);

if (localStorage.getItem('livewire.screencasts.rate')) {
    player.setPlaybackRate(localStorage.getItem('livewire.screencasts.rate'))
}

// Automatically send the user to the next video after completion.
player.on('ended', function() {
    // Don't the next link if there is none
    if (@json(! $screencast->next)) return;
    location.href = '/screencasts/{{ optional($screencast->next)->slug }}';
});

// Remember the user's PlaybackRate.
player.on('playbackratechange', function () {
    player.getPlaybackRate().then(function (rate) {
        localStorage.setItem('livewire.screencasts.rate', rate)
    })
})
</script>
@endpush
