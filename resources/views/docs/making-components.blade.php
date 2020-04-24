## The `make` Command {#make-command}

It is highly recommended that you use the `php artisan make:livewire` command for all new components.

Here are a few examples of usage:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire foo
# Creates Foo.php & foo.blade.php

php artisan make:livewire foo-bar
# Creates FooBar.php & foo-bar.blade.php

php artisan make:livewire foo.bar
# Creates Foo/Bar.php & foo/bar.blade.php

php artisan make:livewire foo --inline
# Creates only Foo.php
@endcomponent

Once created, you can render your components in a Blade file with the `@livewire('component-name')` blade directive.

Think of Livewire components like Blade includes. You can insert `@livewire` anywhere in a Blade view and it will render.

@component('components.code', ['lang' => 'php'])
@verbatim
@livewire('foo')
@livewire('foo-bar')
@livewire('foo.bar')
@livewire(Package\Livewire\Foo::class)
@endverbatim
@endcomponent

If you are on Laravel 7 or greater, you can use the tag syntax.

@component('components.code', ['lang' => 'html'])
<livewire:foo>
@endcomponent

### Modifying Stubs {#modifying-stubs}

You can customize the stubs (templates) that Livewire uses to create new component classes and views using the `livewire:stubs` command.

@component('components.code', ['lang' => 'bash'])
php artisan livewire:stubs
@endcomponent

The above command will create three files:

* `stubs/livewire.stub`
* `stubs/livewire.view.stub`
* `stubs/livewire.inline.stub`

Now, when you run the `make:livewire` command, Livewire will use the above stub files as the template.

## The `move` Command {#move-command}

The `php artisan livewire:move` command will move/rename the component class and blade view, taking care of namespaces and paths

Here is an example of usage:

@component('components.code', ['lang' => 'bash'])
php artisan livewire:move foo bar.baz
# Foo.php|foo.blade.php -> Bar/Baz.php|bar/baz.blade.php
@endcomponent

@component('components.tip')
For convenience, <code>livewire:move</code> is aliased to <code>livewire:mv</code>
@endcomponent

## The `copy` Command {#copy-command}

The `php artisan livewire:copy` command will create copies of the component class and blade view, taking care of namespaces and paths

Here are a few examples of usage:

@component('components.code', ['lang' => 'bash'])
php artisan livewire:copy foo bar
# Copies Foo.php & foo.blade.php to Bar.php and bar.blade.php

php artisan livewire:copy foo bar --force
# Overwrites existing "bar" component
@endcomponent

@component('components.tip')
For convenience, <code>livewire:copy</code> is aliased to <code>livewire:cp</code>
@endcomponent

## The `delete` Command {#delete-command}

The `php artisan livewire:delete` command will remove the component class and blade view.

Here are a few examples of usage:

@component('components.code', ['lang' => 'bash'])
php artisan livewire:delete foo
# Removes Foo.php & foo.blade.php

php artisan livewire:delete foo --force
# Removes without confirmation prompt
@endcomponent

@component('components.tip')
For convenience, <code>livewire:delete</code> is aliased to <code>livewire:rm</code>
@endcomponent

## Manually Registering Components {#manually-registering-components}

You may manually register components using the `Livewire::component` method. 
This can be useful if you have components in another namespace or a composer package.
Typically this should be done in the `boot` method of a service provider. 

@component('components.code', ['lang' => 'php'])
namespace App\Providers;

use Other\Namespace\YourComponent;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireComponentProvider extends ServiceProvider {
    public function boot() {
        Livewire::component('your-component', YourComponent::class);
    }
}
@endcomponent
