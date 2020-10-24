@if (! config('app.debug'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-41657217-15"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-41657217-15');
    </script>
@endif

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="{{ $description ?? 'A full-stack framework for Laravel that takes the pain out of building dynamic UIs.' }}">

<meta property="og:site_name" content="{{ config('app.name') }}"/>
<meta property="og:title" content="{{ $title ? strip_tags($title) . ' | ' : '' }}{{ config('app.name') }}"/>
<meta property="og:description" content="{{ $description ?? 'A full-stack framework for Laravel that takes the pain out of building dynamic UIs.' }}"/>
<meta property="og:url" content="{{ request()->url() }}"/>
<meta property="og:image" content="{{ $social_image ?? 'https://laravel-livewire.com/img/twitter.png' }}"/>
<meta property="og:type" content="website"/>

<meta name="twitter:card" content="{{ $social_size ?? 'summary' }}">

@if ($docsearchApiKey && $docsearchIndexName)
    <meta name="generator" content="tighten_jigsaw_doc">
@endif

<title>{{ $title ? strip_tags($title) . ' | ' : '' }}{{ config('app.name') }}</title>

<link rel="home" href="{{ config('app.url') }}">
<link rel="icon" href="/favicon.ico">

@stack('meta')

<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i,900" rel="stylesheet">
<link rel="stylesheet" href="{{ mix('css/main.css') }}">

<script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>

@if ($docsearchApiKey && $docsearchIndexName)
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css" />
@endif

@livewireStyles
