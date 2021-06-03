@include('includes.screencast-cta')

## Requirements {#requirements}

1. PHP 7.2.5 or higher
2. Laravel 7.0 or higher

Visit the [composer.json file on Github](https://github.com/livewire/livewire/blob/master/composer.json) for the complete list of package requirements.

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

You can alternatively use the tag syntax.

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
php artisan livewire:publish --config
@endverbatim
@endcomponent

## Publishing Frontend Assets {#publish-assets}

If you prefer the JavaScript assets to be served by your web server not through Laravel, use the `livewire:publish` command:

@component('components.code', ['lang' => 'bash'])
@verbatim
php artisan livewire:publish --assets
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

## Configuring The Asset Base URL

By default, Livewire serves its JavaScript portion (`livewire.js`) from the following route in your app: `/livewire/livewire.js`.

The actual script tag that gets generated defaults to:<br> `<script src="/livewire/livewire.js"></script>`

There are two scenarios that will cause this default behavior to break:

1. You publish the Livewire assets and are now serving them from a sub-folder like "assets".

2. Your app is hosted on a non-root path on your domain. For example: `https://your-laravel-app.com/application`. In this case, the actual assets will be served from `/application/livewire/livewire.js`, but the generated script tag, will be trying to fetch `/livewire/livewire.js`.

To solve either of these issues, you can configure the "asset_url" in `config/livewire.php` to customize what's prepended to the `src=""` attribute.

For example, after publishing Livewire's config file, here are the settings that would fix the above two issues:

1. `'asset_url' => '/assets'`
2. `'asset_url' => '/application'`
