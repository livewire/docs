---
title: Security
description: todo
extends: _layouts.documentation
section: content
---

# Security

## Filtering Middleware

By default, Livewire request inherit the middleware of the page the component was loaded on. If there is middleware you'd like to exclude from subsequent Livewire requests, you can use the `filterMiddleware()` method like so:

In the following example, we are excluding `LogAdminAreaAccessMiddleware` from being executed on livewire requests.
@codeComponent([
    'viewName' => 'app/Providers/AppServiceProvider.php',
    'className' => 'App\Providers\AppServiceProvider',
])
@slot('class')
@verbatim
public function boot()
{
    // Only exclude LogAdminAreaAccessMiddleware
    Livewire::filterMiddleware(function($middleware) {
        return ! $middleware instanceof LogAdminAreaAccessMiddleware;
    });
}
@endverbatim
@endslot
@endcodeComponent

@warning
Using closure middlewares is not supported on Livewire requests (because they have to be serialized), and an error is thrown.
If you have any closure middleware in your application, you may consider moving them to a class middleware or use the <code>Livewire::filterMiddleware()</code> to exclude them.
@endwarning

@codeComponent([
    'viewName' => 'app/Providers/AppServiceProvider.php',
    'className' => 'App\Providers\AppServiceProvider',
])
@slot('class')
@verbatim
public function boot()
{
    // Exclude all closure middlewares
    Livewire::filterMiddleware(function($middleware) {
        return ! $middleware instanceof Closure;
    });
}
@endverbatim
@endslot
@endcodeComponent
