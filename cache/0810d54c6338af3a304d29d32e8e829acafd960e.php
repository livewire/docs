---
title: Making Components
extends: _layouts.documentation
section: content
---

## The `make` Command {#make-command}

It is highly recommended that you use the `php artisan make:livewire` command for all new components.

Here are a few examples of usage:

<?php $__env->startComponent('_partials.code', ['lang' => 'bash']); ?>
# Creates Foo.php & foo.blade.php
php artisan make:livewire foo

# Creates FooBar.php & foo-bar.blade.php
php artisan make:livewire foo-bar

# Creates Foo/Bar.php & foo/bar.blade.php
php artisan make:livewire foo.bar
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/0a8782c3da0255c5c37e15b7f0fa71c49c7df9c9.blade.md ENDPATH**/ ?>