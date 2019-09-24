@extends('_layouts.master')

@php
$page->siteName = 'Building Livewire Podcast';
$page->social_image = 'https://laravel-livewire.com/assets/img/podcast-artwork.png';
@endphp

@push('meta')
<link rel="alternate" type="application/rss+xml" title="Building Livewire RSS" href="https://rss.simplecast.com/podcasts/10939/rss"/>
@endpush

@section('content')
<div style="background: #10B3CB; background-image: linear-gradient(to bottom, rgba(245, 246, 252, 0), rgba(0, 0, 0, 0.2));">
    <div class="container mx-auto px-12 py-12 text-xl flex-col md:flex-row flex justify-between items-center" style="max-width: 900px">
        <div class="md:w-1/2 py-16">
                <h2 class="text-3xl md:text-5xl m-0 text-white">{{ $page->title }}</h2>
                <div class="font-bold mb-3 text-white text-base opacity-75">
                    <span>
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ $page->published_on }}
                    </span>
                    <span class="ml-3">
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ $page->duration_in_minutes }}
                    </span>
                </div>
                <p class="m-0 text-base text-white">{{ $page->description }}</p>
        </div>

        <div class="">
            {!! $page->iframe_markup !!}
        </div>
    </div>
</div>

<div class="container mx-auto py-8 px-6 md:px-0" style="max-width: 760px;">
<h3>Transcript:</h3>
<p>{!! (new TightenCo\Jigsaw\Parsers\ParsedownExtraParser())->parse($page->long_description) !!}</p>
</div>
@overwrite
