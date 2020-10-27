<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body class="font-sans leading-normal text-gray-800 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col lg:h-screen">
            @include('includes.header')
            @yield('content')
            @include('includes.footer')
        </div>
        @include('includes.scripts')
    </body>
</html>
