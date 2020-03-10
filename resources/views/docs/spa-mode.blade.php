
## Turbolinks {#turbolinks}

Livewire recommends you use Turbolinks in your apps to make page transitions faster. It is very possible to achieve a "SPA" feeling application written with Turbolinks & Livewire.

If you have Turbolinks installed on the page ([installation instructions here](https://github.com/turbolinks/turbolinks)), Livewire will handle the rest.

## Single Page Components {#single-page-components}

If you find yourself writing controllers and views that only return a Livewire component, you might want to use Livewire's routing helpers to cut out the extra boilerplate code. Take a look at the following example:

*Before*
@component('components.code', ['lang' => 'php'])
@verbatim
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
@endverbatim
@endcomponent

**After**
@component('components.code', ['lang' => 'php'])
// Route
Route::livewire('/home', 'counter');
@endcomponent

Note: for this feature to work, Livewire assumes you have a layout stored in `resources/views/layouts/app.blade.php` that yields a "content" section (`@@yield('content')`)

### Custom Layout File {#custom-layout-file}
If you use a different layout file or section name, you can configure these in the standard way you configure laravel routes:

@component('components.code', ['lang' => 'php'])
// Customizing layout
Route::livewire('/home', 'counter')
    ->layout('layouts.base');

// Customizing section (@@yield('body'))
Route::livewire('/home', 'counter')
    ->section('body');

// Passing parameters to the layout (Like native @@extends('layouts.app', ['title' => 'foo']))
Route::livewire('/home', 'counter')
    ->layout('layouts.app', [
        'title' => 'foo'
    ]);
@endcomponent

You can also configure these settings for an entire route group using the group option array syntax:

@component('components.code', ['lang' => 'php'])
Route::group(['layout' => 'layouts.base', 'section' => 'body'], function () {
    //
});
@endcomponent

Or the fluent alternative:
@component('components.code', ['lang' => 'php'])
Route::layout('layouts.base')->section('body')->group(function () {
    //
});
@endcomponent


### Route Parameters {#route-params}

Often you need to access route parameters inside your controller methods. Because we are no longer using controllers, Livewire attempts to mimick this behavior through it's `mount` lifecycle hook. For example:

**web.php**
@component('components.code', ['lang' => 'php'])
Route::livewire('/contact/{id}', 'show-contact');
@endcomponent

**App\Http\Livewire\ShowContact.php**
@component('components.code', ['lang' => 'php'])
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
@endcomponent

As you can see, the `mount` method in a Livewire component is acting like a controller method would as far as it's parameters go. If you visit `/contact/123`, the `$id` variable passed into the `mount` method will contain the value `123`.

### Route Model Binding {#route-model-binding}

Like you would expect, Livewire components implement all functionality you're used to in your controllers including route model binding. For example:

**web.php**
@component('components.code', ['lang' => 'php'])
Route::livewire('/contact/{user}', 'show-contact');
@endcomponent

**App\Http\Livewire\ShowContact.php**
@component('components.code', ['lang' => 'php'])
use Livewire\Component;

class ShowContact extends Component
{
    public $contact;

    public function mount(User $user)
    {
        $this->contact = $user;
    }
}
@endcomponent

Now, after visiting `/contact/123`, the value passed into `mount` will be an instance of the `User` model with id `123`.
