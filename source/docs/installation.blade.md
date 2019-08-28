---
title: Installation
description: todo
extends: _layouts.documentation
section: content
---

# Installation

Livewire has both a PHP component AND a Javascript component. You need to make sure both are available in your project before you can use it.

## Step 1: Include the PHP {#include-php}
@code(['lang' => 'bash'])
@verbatim
composer require calebporzio/livewire
@endverbatim
@endcode

## Step 2: Include the JavaScript {#include-js}
Add the following Blade directive before the closing `body` tag in your template.

@code
@verbatim
    ...
    @livewireAssets
</body>
</html>
@endverbatim
@endcode

Livewire will load its JavaScript assets from the "relative root". For example, here's the `<script>` tag this directive will generate by default:

`<script src="/livewire/livewire.js></script>`

If your app's root isn't the domain root, for example `http://yourapp.com/admin`, the Livewire assets won't load because they would need the following script tag url:

`<script src="http://yourapp.com/admin/livewire/livewire.js></script>`

To fix this, you can optionally pass in a `base_url` option to the `@livewireAssets` directive like so:

@code(['lang' => 'php'])
@verbatim
    ...
    @livewireAssets(['base_url' => 'http://yourapp.com/admin']);
</body>
</html>
@endverbatim
@endcode
