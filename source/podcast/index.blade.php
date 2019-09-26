@extends('_layouts.master')

@php
$page->title = '';
$page->social_image = 'https://laravel-livewire.com/assets/img/podcast-artwork.png';
$page->siteName = 'Building Livewire Podcast';
$page->description = 'Follow along on the Livewire journey. We\'ll talk about where the project came from, where it\'s going, and all the fun problems to solve along the way!';
@endphp

@push('meta')
<link rel="alternate" type="application/rss+xml" title="Building Livewire RSS" href="https://rss.simplecast.com/podcasts/10939/rss"/>
@endpush

@section('content')
<div style="background: #10B3CB; background-image: linear-gradient(to bottom, rgba(245, 246, 252, 0), rgba(0, 0, 0, 0.2));">
    <div class="container mx-auto px-12 pt-12 text-xl flex-col md:flex-row flex justify-between" style="max-width: 900px">
        <div class="md:w-1/2 py-16">
            <img class="mb-2" src="/assets/img/podcast-title.svg" alt="Building Livewire Podcast Title">
            <div class="text-white text-base">
                {{ $page->description }}
            </div>
        </div>

        <div class="flex flex-col-reverse items-center">
            <img class="w-48 pt-8" src="/assets/img/podcast-head.svg" alt="Building Livewire Podcast Logo">
            {!! $podcasts->first()->iframe_markup !!}
        </div>
    </div>
</div>

<div class="container mx-auto py-8 px-4" style="max-width: 760px;">
    @foreach ($podcasts as $podcast)
        <div class="flex mb-8 border-b pb-6">
            <div class="w-16 md:w-32 flex-shrink-0"><img src="/assets/img/podcast-artwork.svg"></div>
            <div class="pl-4 md:pl-12">
                <h2 class="text-2xl m-0"><a class="text-blue-800" href="/podcasts/{{ $podcast->filename }}">{{ $podcast->title }}</a></h2>
                <div class="font-bold mb-3 text-gray-500 text-sm">
                    <span>
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ $podcast->published_on }}
                    </span>
                    <span class="ml-3">
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ $podcast->duration_in_minutes }}
                    </span>
                </div>
                <p class="m-0 text-gray-700 text-base">{{ $podcast->description }}</p>
            </div>
        </div>
    @endforeach
</div>
@overwrite
