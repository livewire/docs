---
title: Installation
description: todo
extends: _layouts.documentation
section: content
---

# Installation

Livewire has both a PHP component AND a Javascript component. You need to make sure both are available in your project before you can use it.

## Step 1: Include the PHP
@code(['lang' => 'bash'])
@verbatim
composer require calebporzio/livewire
@endverbatim
@endcode

## Step 2: Include the JavaScript
Add the following Blade directive before the closing `body` tag in your template.

@code
@verbatim
    ...
    @livewireAssets
</body>
</html>
@endverbatim
@endcode
