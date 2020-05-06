* [Livewire Directive (`@@livewire`)](#livewire-directive) { .text-blue-800 }
  * [Passing Initial Parameters](#parameters) { .font-normal.text-sm.text-blue-800 }
  * [Dependancy Injection](#injecting-parameters) { .font-normal.text-sm.text-blue-800 }
  * [Accessing The Request](#the-request) { .font-normal.text-sm.text-blue-800 }
* [Livewire Route Registration (`Route::livewire()`)](#route-registration) { .text-blue-800 }
  * [Custom Layouts](#custom-layout) { .font-normal.text-sm.text-blue-800 }
  * [Route Parameters](#route-params) { .font-normal.text-sm.text-blue-800 }
  * [Route Model Binding](#route-model-binding) { .font-normal.text-sm.text-blue-800 }
* [The Render Method (`render()`)](#render-method) { .text-blue-800 }
  * [Returning Blade Views](#returning-blade) { .font-normal.text-sm.text-blue-800 }
  * [Returning Template String](#returning-strings) { .font-normal.text-sm.text-blue-800 }

<div>&nbsp;</div>

@include('includes.screencast-cta')


## Livewire Directive (`@@livewire`) {#livewire-directive}

The most basic way to render a Livewire component on a page is using the `@@livewire` blade directive:

@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    @livewire('search-posts')
</div>
@endverbatim
@endcomponent

If you are on Laravel 7 or greater, you can use the tag syntax.

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:search-posts />
@endverbatim
@endcomponent

### Passing Initial Parameters {#parameters}

You can pass data into a component by passing additional parameters into the <code>&#64;livewire</code> directive. For example, let's say we have a `ShowContact` Livewire component that needs to know which contact to show. Here's how you would pass in a `contact` model.

@component('components.code', ['lang' => 'php'])
@verbatim
@livewire('show-contact', ['contact' => $contact])
@endverbatim
@endcomponent

If you are on Laravel 7 or greater, you can use the tag syntax.

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:show-contact :contact="$contact">
@endverbatim
@endcomponent

Now, you can intercept those parameters and store the data as public properties using the `mount()` method/lifecycle hook.

@component('components.tip')
In Livewire components, you use the <code>mount()</code> instead of a class constructor (<code>__construct()</code>) like you may be used to.
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($contact)
    {
        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}
@endverbatim
@endcomponent

### Dependancy Injection {#injecting-parameters}

Like a controller, you can inject dependencies by adding type-hinted parameters before passed-in ones.

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;
use \Illuminate\Session\SessionManager

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount(SessionManager $session, $contact)
    {
        $session->put("contact.{$contact->id}.last_viewed", now());

        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}
@endverbatim
@endcomponent

### Accessing The Request {#the-request}

Because `mount()` runs during the initial page load, it is the only place in a Livewire component you can reliably access Laravel's request object.

For example, you can set the initial value of a property based on a request parameter (possibly something passed in the query-string).

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;
use \Illuminate\Session\SessionManager

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($contact, $sectionHeading = '')
    {
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->sectionHeading = request('section_heading', $sectionHeading);
    }

    ...
}
@endverbatim
@endcomponent


## Livewire Route Registration {#route-registration}

If you find yourself writing controllers and views that only return a Livewire component, you might want to use Livewire's routing helper to cut out the extra boilerplate code. Take a look at the following example:

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

### Custom Layout {#custom-layout}
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


## The Render Method {#render-method}

A Livewire component's `render` method gets called on the initial page load AND every subsequent component update.

@component('components.tip')
In simple components, you don't need to define a `render` method yourself. The base Livewire component class has a dynamic `render` method included.
@endcomponent

### Returning Blade Views {#returning-blade}
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

@component('components.warning')
Make sure your Blade view only has ONE root element.
@endcomponent

@component('components.code-component', [
    'className' => 'ShowPosts.php',
    'viewName' => 'show-posts.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all(),
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    @foreach ($posts as $post)
        @include('includes.post', $post)
    @endforeach
</div>
@endverbatim
@endslot
@endcomponent

### Returning Template Strings {#returning-strings}
If your Livewire project uses Laravel 7 or above, you can optionally return a Blade template string from `->render()`.

@component('components.code-component', ['className' => 'DeletePost.php'])
@slot('class')
@verbatim
use Livewire\Component;

class DeletePost extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function delete()
    {
        $this->post->delete();
    }

    public function render()
    {
        return <<<'blade'
            <div>
                <button wire:click="delete">Delete Post</button>
            </div>
        blade;
    }
}
@endverbatim
@endslot
@endcomponent

@component('components.tip')
For inline components like above, you should use the <code>--inline</code> flag during creation: <code>artisan make:livewire delete-post --inline</code>
@endcomponent
