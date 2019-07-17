---
title: Security
description: todo
extends: _layouts.documentation
section: content
---

# Security

## Filtering middlewares
Handling livewire requests should be similar to handling regular requests via controllers, but in case you need to exclude one or many middlewares from being executed on a livewire request then you can define a filter callback to tell livewire what middlewares should be excluded.
The filter callback will be executed on each of the defined middlewares and only the ones when `true` is returned will be executed on a livewire request.

In the following example we want to exclude the `LogAdminAreaAccessMiddleware` from being executed on livewire requests.
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
On the initial load page, the defined middlewares will be serialized for livewire requests. Using closure middlewares is not supported and an error is raised.
If you have any defined closure middlewares in your application then you may consider moving them to a class middleware or use the `Livewire::filterMiddleware()` to exclude them as generally closure middlewares are defined within controller constructors and their action is limited to controllers. 
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