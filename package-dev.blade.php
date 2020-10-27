
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
