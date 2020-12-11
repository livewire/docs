
## Registering Custom Components {#registering-components}

You may manually register components using the `Livewire::component` method.
This can be useful if you want to provide Livewire components from a composer package.
Typically this should be done in the `boot` method of a service provider.

@component('components.code', ['lang' => 'php'])
class YourPackageServiceProvider extends ServiceProvider {
    public function boot() {
        Livewire::component('some-component', SomeComponent::class);
    }
}
@endcomponent

Now, applications with your package installed can consume your component in their views like so:

@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    @livewire('some-component')
</div>
@endverbatim
@endcomponent

## Testing Components

You may wish to write tests that use the `Livewire::test` helper in your package. Out of the box, this won't work
because Livewire won't be able to find your components. Don't worry, you can fix this in two simple steps.

### Tell Livewire where to find your package views

First, we need to show Livewire how to find your package views. In any test that extends `Orchestra\Testbench\TestCase`,
you can use the `getEnvironmentSetup` method for this.

@component('components.code', ['lang' => 'php'])
class MyLivewireTest extends Orchestra\Testbench\TestCase {
    protected function getEnvironmentSetup($app)
    {
        $app['config']->set('view.paths', [__DIR__ . '/path/to/your/package/views']);
    }
}
@endcomponent

Your view directory should mirror a real application by including a `livewire` directory. All livewire views should be
placed in there.

### Tell Composer how to load your Components

The second step is making Livewire think it's in a standard Laravel application. Composer allows us to do this using
the `autoload-dev` entry in your `composer.json` file.

@component('components.code', ['lang' => 'json'])
"autoload-dev": {
    "psr-4": {
        "App\\Http\\Livewire\\": "path/to/your/livewire/components"
    }
}
@endcomponent

Its important that you use `autoload-dev` instead of `autoload` for this to ensure that you don't end up breaking
namespacing in the Laravel application your package is installed in.

The great thing about this approach is that it even works for Livewire Components that you will publish to the
Laravel application.