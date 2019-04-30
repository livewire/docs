# Registering Components

Registering Livewire components should feel similar to registering Vue components, or Blade components.

You can register them wherever you like, but it will probably make the most sense to register them inside your AppServiceProvider.php or a separate LivewireServiceProvider that you make.

**AppServiceProvider.php**
```php
public function boot()
{
    Livewire::component('counter', \App\Http\Livewire\Counter::class);
}
```
