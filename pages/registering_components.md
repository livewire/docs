# Registering Components

Registering Livewire components should feel similar to registering Vue components, or Blade components.

You can register them wherever you like, but it will probably make the most sense to register them inside your AppServiceProvider.php or a separate LivewireServiceProvider that you make.

<div title="Component">
<div title="Component__class">

app/Providers/AppServiceProvider.php
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('counter', \App\Http\Livewire\Counter::class);
    }
}
```
</div>
</div>
