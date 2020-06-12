
Livewire recommends you use Turbolinks in your apps to make page transitions faster. It is very possible to achieve a "SPA" feeling application written with Turbolinks & Livewire.

To use Turbolinks with Livewire, [install Turbolinks](https://github.com/turbolinks/turbolinks) using NPM:

@component('components.code', ['lang' => 'bash'])
npm i turbolinks --save-dev
@endcomponent

Then, inside of your `resources/js/app.js` file, boot turbolinks inside of the `livewire:load` event:

@component('components.code', ['lang' => 'js'])
// resources/js/app.js

const turbolinks = require('turbolinks');

document.addEventListener("livewire:load", function(event) {
    turbolinks.start();
});
@endcomponent

Since Turbolink cannot be registered in the `<body>` of your HTML, you must register your app & Livewire scripts into `<head>` of your document.

Here is an example base layout:

@component('components.code', ['lang' => 'html'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Livewire') }}</title>
        
        <!-- Scripts -->
        <script src="{{ asset(mix('js/app.js')) }}" data-turbolinks-track="reload"></script>
        <livewire:scripts>
        @stack('scripts')

        <!-- Styles -->
        <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" data-turbolinks-track="reload">
        <livewire:styles>
        @stack('styles')
    </head>
    <body>
        @yield('body')
    </body>
</html>
@endcomponent

Livewire will handle the rest.
