@include('includes.screencast-cta')

## Install The Package {#install-package}

@component('components.code', ['lang' => 'bash'])
composer require livewire/livewire
@endcomponent

## Include The Assets {#include-js}
Add the following Blade directives in the `head` tag, and before the end `body` tag in your template.

@component('components.code')
@verbatim
<html>
<head>
    ...
    @livewireStyles
</head>
<body>
    ...
    @livewireScripts
</body>
</html>
@endverbatim
@endcomponent

If you are on Laravel 7 or higher, you can use the new tag syntax.

@component('components.code')
@verbatim
<livewire:styles />
...
<livewire:scripts />
@endverbatim
@endcomponent

That's it! That's all you need to start using Livewire. Everything else on this page is optional.

## Publishing The Config File {#publishing-config}

Livewire aims for "zero-configuration" out-of-the-box, but some users require more configuration options.

You can publish Livewire's config file with the following artisan command:

@component('components.code', ['lang' => 'bash'])
@verbatim
php artisan vendor:publish --tag=livewire:config
@endverbatim
@endcomponent

## Configuring The Asset Base URL

By default, Livewire serves its JavaScript portion (`livewire.js`) from the following route in your app: `/livewire/livewire.js`.

The actual script tag that gets generated defaults to: `<script src="/livewire/livewire.js"`.

There are two scenerios that will cause this default behavior to break:

1. You publish the Livewire assets and are now serving them from a sub-folder like "assets".

2. Your app is hosted on a non-root path on your domain. For example: `https://your-laravel-app.com/application`. In this case, the actual assets will be served from `/application/livewire/livewire.js`, but the generated script tag, will be trying to fetch `/livewire/livewire.js`.

To solve either of these issues, you can configure the "asset_base_url" setting to customize what's prepended to the `src=""` attribute.

For example, after publishing Livewire's config file, here are the settings that would fix the above two issues:
1. `'asset_base_url' => '/assets'`
2. `'asset_base_url' => '/application'`

## Publishing Assets {#publish-assets}

If you prefer the JavaScript assets to be served by your web server not through Laravel, use the `vendor:publish` command:

@component('components.code', ['lang' => 'bash'])
@verbatim
php artisan vendor:publish --tag=livewire:assets
@endverbatim
@endcomponent

To keep the assets up-to-date and avoid issues in future updates, we **highly recommend** adding the command to the `post-autoload-dump` scripts in your `composer.json` file:

@component('components.code', ['lang' => 'json'])
@verbatim
{
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan vendor:publish --force --tag=livewire:assets --ansi"
        ]
    }
}
@endverbatim
@endcomponent
