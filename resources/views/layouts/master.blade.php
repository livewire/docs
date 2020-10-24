<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body class="flex flex-col justify-between min-h-screen font-sans leading-normal text-gray-800 antialiased bg-gray-100">
        @include('includes.header')
        <main role="main" class="lg:flex-1 lg:flex lg:flex-col">
            @yield('content')
        </main>
        @include('includes.footer')
        @include('includes.scripts')
    </body>
</html>
