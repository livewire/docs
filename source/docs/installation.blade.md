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
You can either include the JavaScript via the provided Blade helper (easiest), or include it via NPM if you have a build pipeline for your JavaScript.

### Option A) Blade Snippet

@code
@verbatim
    ...
    {!! Livewire::scripts() !!}
</body>
</html>
@endverbatim
@endcode

<div title="Warning"><div title="Warning__content">

Including the JavaScript this way will result in the JavaScript being loaded directly on the page. This should be used for experimentation only. Option B will utilize the browser's caching to reduce page sizes and a faster overall experience.
</div></div>

### Option B) install via NPM

@code(['lang' => 'bash'])
@verbatim
npm install laravel-livewire --save-dev
@endverbatim
@endcode

@code(['lang' => 'js'])
@verbatim
import Livewire from 'laravel-livewire'

window.livewire = new Livewire
@endverbatim
@endcode
