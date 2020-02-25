---
title: Installation
extends: _layouts.documentation
section: content
---

Livewire has both a PHP component AND a Javascript component. You need to make sure both are available in your project before you can use it.

## Install the package {#install-package}
@code(['lang' => 'bash'])
@verbatim
composer require livewire/livewire
@endverbatim
@endcode

## Include The Assets {#include-js}
Add the following Blade directives in the `head` tag, and before the end `body` tag in your template.

@code
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
@endcode

If you are on Laravel 7 or higher, you can use the new tag syntax.

@code
@verbatim
<livewire:styles>
...
<livewire:scripts>
@endverbatim
@endcode

## Publishing The Config File {#publishing-config}

Livewire aims for "zero-configuration" out-of-the-box, but some users require more configuration options.

You can publish Livewire's config file with the following artisan command:

@code(['lang' => 'bash'])
@verbatim
php artisan vendor:publish --tag=livewire:config
@endverbatim
@endcode

## Configuring The Asset Base URL

By default, Livewire serves it's JavaScript portion (`livewire.js`) from the following route in your app: `/livewire/livewire.js`.

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

@code(['lang' => 'bash'])
@verbatim
php artisan vendor:publish --tag=livewire:assets
@endverbatim
@endcode

To keep the assets up-to-date and avoid issues in future updates, we **highly recommend** adding the command to the `post-autoload-dump` scripts in your `composer.json` file:

@code(['lang' => 'json'])
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
@endcode
