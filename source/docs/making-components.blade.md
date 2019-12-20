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

Once created, you can render your components in a Blade file with the `@livewire('component-name')` blade directive.

Think of Livewire components like Blade includes. You can insert `@livewire` anywhere in a Blade view and it will render.

@code(['lang' => 'php'])
@verbatim
@livewire('foo')
@livewire('foo-bar')
@livewire('foo.bar')
@endverbatim
@endcode

@tip
For convenience, <code>make:livewire</code> is aliased to <code>livewire:make</code> and <code>livewire:touch</code>
@endtip

### Making Components From Stubs {#making-from-stubs}

You can customize the stubs (templates) that Livewire uses to create new component classes and views using the `livewire:stub` command.

@code(['lang' => 'bash'])
php artisan livewire:stub
@endcode

The above command will create two files:
* `app\Livewire\Http\Stubs\Default.stub`
* `resources\views\livewire\stubs\default.stub`

Now, when you run the `make:livewire` command, Livewire will use the above stub files as the template.

You can create custom stubs with the following command:
@code(['lang' => 'bash'])
php artisan livewire:stub foo
@endcode

And you can tell Livewire to reference it when making a component by adding the `--stub` option to the make command:
@code(['lang' => 'bash'])
php artisan make:livewire --stub=foo
@endcode

## The `move` Command {#move-command}

The `php artisan livewire:move` command will move/rename the component class and blade view, taking care of namespaces and paths

Here is an example of usage:

@code(['lang' => 'bash'])
# Moves Foo.php & foo.blade.php to Bar/Baz.php and bar/baz.blade.php
php artisan livewire:move foo bar.baz
@endcode

@tip
For convenience, <code>livewire:move</code> is aliased to <code>livewire:mv</code>
@endtip

## The `copy` Command {#copy-command}

The `php artisan livewire:copy` command will create copies of the component class and blade view, taking care of namespaces and paths

Here are a few examples of usage:

@code(['lang' => 'bash'])
# Copies Foo.php & foo.blade.php to Bar/Baz.php and bar/baz.blade.php
php artisan livewire:copy foo bar.baz

# Copies Foo.php & foo.blade.php to Bar.php and bar.blade.php
# (overwriting existing Bar.php and bar.blade.php)
php artisan livewire:copy foo bar --force
@endcode

@tip
For convenience, <code>livewire:copy</code> is aliased to <code>livewire:cp</code>
@endtip

## The `delete` Command {#delete-command}

The `php artisan livewire:delete` command will remove the component class and blade view.

Here are a few examples of usage:

@code(['lang' => 'bash'])
# Removes Foo.php & foo.blade.php (with confirmation prompt)
php artisan livewire:delete foo

# Removes Foo.php & foo.blade.php (without confirmation prompt)
php artisan livewire:delete foo --force

@endcode

@tip
For convenience, <code>livewire:delete</code> is aliased to <code>livewire:rm</code>
@endtip
