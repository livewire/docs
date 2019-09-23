---
title: SPA Mode
extends: _layouts.documentation
section: content
---

While Livewire makes individual pages feel smooth, it doesn't give transitions between pages the same love. Livewire plans to support this functionality out of the box, but for now, it is recommended to use Turbolinks.

Fortunately, getting Turbolinks to play nicely with Livewire is simple. Let's walk through it.

Checkout the [Turbolinks documentation](https://github.com/turbolinks/turbolinks) for installation instructions.

Now, add the following JS in a script tag at the bottom of the page, or in your `app.js` file.

<?php $__env->startComponent('_partials.code', ['lang' => 'js']); ?>
Turbolinks.start()

document.addEventListener('turbolinks:load', () => {
    if (! window.livewire) {
        window.livewire = new Livewire()
        window.livewire.start()
    } else {
        window.livewire.restart()
    }
})
<?php echo $__env->renderComponent(); ?>

And that's it! This little snippet tells Turbolinks to reload Livewire every time a new page is visited or returned to.

## Render Component As Entire Page {#render-as-entire-page}

If you find yourself writing controllers and views that only return a Livewire component, you might want to use Livewire's routing helpers to cut out the extra boilerplate code. Take a look at the following example:

*Before*
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

// Route
Route::get('/home', 'HomeController@show');

// Controller
class HomeController extends Controller
{
    public function show()
    {
        return view('home');
    }
}

// View
@extends('layouts.app')

@section('content')
    @livewire('counter')
@endsection

<?php echo $__env->renderComponent(); ?>

**After**
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
// Route
Route::livewire('/home', 'counter');
<?php echo $__env->renderComponent(); ?>

Note: for this feature to work, Livewire assumes you have a layout stored in `resources/views/layouts/app.blade.php` that yields a "content" section (`@yield('content')`)

### Custom Layout File {#custom-layout-file}
If you use a different layout file or section name, you can configure these in the standard way you configure laravel routes:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
// Customizing layout
Route::livewire('/home', 'counter')
    ->layout('layouts.base');

// Customizing section (@yield('body'))
Route::livewire('/home', 'counter')
    ->section('body');
<?php echo $__env->renderComponent(); ?>

You can also configure these settings for an entire route group using the group option array syntax:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
Route::group(['layout' => 'layouts.base', 'section' => 'body'], function () {
    //
});
<?php echo $__env->renderComponent(); ?>

Or the fluent alternative:
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
Route::layout('layouts.base')->section('body')->group(function () {
    //
});
<?php echo $__env->renderComponent(); ?>

### Route Parameters {#route-params}

Often you need to access route parameters inside your controller methods. Because we are no longer using controllers, Livewire attempts to mimick this behavior through it's `mount` lifecycle hook. For example:

**web.php**
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
Route::livewire('/contact/{id}', 'show-contact');
<?php echo $__env->renderComponent(); ?>

**App\Http\Livewire\ShowContact.php**
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
use Livewire\Component;

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($id)
    {
        $contact = User::find($id);

        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}
<?php echo $__env->renderComponent(); ?>

As you can see, the `mount` method in a Livewire component is acting like a controller method would as far as it's parameters go. If you visit `/contact/123`, the `$id` variable passed into the `mount` method will contain the value `123`.

### Route Model Binding {#route-model-binding}

Like you would expect, Livewire components implement all functionality you're used to in your controllers including route model binding. For example:

**web.php**
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
Route::livewire('/contact/{user}', 'show-contact');
<?php echo $__env->renderComponent(); ?>

**App\Http\Livewire\ShowContact.php**
<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
use Livewire\Component;

class ShowContact extends Component
{
    public $contact;

    public function mount(User $user)
    {
        $this->contact = $user;
    }
}
<?php echo $__env->renderComponent(); ?>

Now, after visiting `/contact/123`, the value passed into `mount` will be an instance of the `User` model with id `123`.
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/ea93b08861a6f82a1914e2748d2dc8be9461f4fb.blade.md ENDPATH**/ ?>