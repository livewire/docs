---
title: Security
extends: _layouts.documentation
section: content
---

## Filtering Middleware {#filtering-middleware}

By default, Livewire request inherit the middleware of the page the component was loaded on. If there is middleware you'd like to exclude from subsequent Livewire requests, you can use the `filterMiddleware()` method like so:

In the following example, we are excluding `LogAdminAreaAccessMiddleware` from being executed on livewire requests.
<?php $__env->startComponent('_partials.code-component', [
    'viewName' => 'app/Providers/AppServiceProvider.php',
    'className' => 'App\Providers\AppServiceProvider',
]); ?>
<?php $__env->slot('class'); ?>

public function boot()
{
    // Only exclude LogAdminAreaAccessMiddleware
    Livewire::filterMiddleware(function($middleware) {
        return ! $middleware instanceof LogAdminAreaAccessMiddleware;
    });
}

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.warning'); ?>
Using closure middlewares is not supported on Livewire requests (because they have to be serialized), and an error is thrown.
If you have any closure middleware in your application, you may consider moving them to a class middleware or use the <code>Livewire::filterMiddleware()</code> to exclude them.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code-component', [
    'viewName' => 'app/Providers/AppServiceProvider.php',
    'className' => 'App\Providers\AppServiceProvider',
]); ?>
<?php $__env->slot('class'); ?>

public function boot()
{
    // Exclude all closure middlewares
    Livewire::filterMiddleware(function($middleware) {
        return ! $middleware instanceof Closure;
    });
}

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/d8e8837c2fb62f8412ecd67f82927f9f3ee20c88.blade.md ENDPATH**/ ?>