
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

To use Livewire, VueJS and Turbolinks at the same time, you will need to create your Vue instance inside of the `turbolinks:load` event.

Below is a full example of using all three:

@component('components.code', ['lang' => 'js'])
// resources/js/app.js

const turbolinks = require('turbolinks');

document.addEventListener("livewire:load", function(event) {
    // Boot turbolinks after Livewire loads.
    turbolinks.start();
});

document.addEventListener('turbolinks:load', () => {
    // Construct the Vue app instance after turbolinks initiates a load.
    const app = new Vue({
        el: '#app'
    });
});
@endcomponent

Since Turbolinks cannot be placed in the `<body>` of your HTML, you must register the Livewire scripts into `<head>` of your document.

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
        <script src="{{ asset(mix('js/app.js')) }}" defer data-turbolinks-track="reload"></script>
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
