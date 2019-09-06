---
title: Making Components
extends: _layouts.documentation
section: content
---

## The `make` Command {#make-command}

It is highly recommended that you use the `php artisan make:livewire` command for all new components.

Here are a few examples of usage:

@code(['lang' => 'bash'])
# Creates Foo.php & foo.blade.php
php artisan make:livewire foo

# Creates FooBar.php & foo-bar.blade.php
php artisan make:livewire foo-bar

# Creates Foo/Bar.php & foo/bar.blade.php
php artisan make:livewire foo.bar
@endcode
