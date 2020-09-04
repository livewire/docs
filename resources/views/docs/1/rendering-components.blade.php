* [As Components](#livewire-directive) { .text-blue-800 }
  * [Passing Parameters](#parameters) { .font-normal.text-sm.text-blue-800 }
  * [Dependency Injection](#injecting-parameters) { .font-normal.text-sm.text-blue-800 }
* [As Pages](#route-registration) { .text-blue-800 }
  * [Configuring Different Layouts](#custom-layout) { .font-normal.text-sm.text-blue-800 }
  * [Route Parameters](#route-params) { .font-normal.text-sm.text-blue-800 }
  * [Route Model Binding](#route-model-binding) { .font-normal.text-sm.text-blue-800 }
* [The Render Method (`render()`)](#render-method) { .text-blue-800 }
  * [Returning Blade Views](#returning-blade) { .font-normal.text-sm.text-blue-800 }
  * [Returning Template String](#returning-strings) { .font-normal.text-sm.text-blue-800 }

<div>&nbsp;</div>

@include('includes.screencast-cta')

## As Components {#livewire-directive}

The most basic way to render a Livewire component on a page is using the `<livewire:` tag syntax:

@component('components.code', ['lang' => 'html'])
@verbatim
<div>
    <livewire:show-posts />
</div>
@endverbatim
@endcomponent

Alternatively you can use the `@@livewire` blade directive:

@component('components.code', ['lang' => 'html'])
@verbatim
    @livewire('show-posts')
@endverbatim
@endcomponent

If you have a component inside of a sub-folder with its own namespace, you must use a dot (`.`) prefixed with the namespace.

For example, if we have a `ShowPosts` component inside of a `app/Http/Livewire/Nav` folder, we would indicate it as such:

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:nav.show-posts />
@endverbatim
@endcomponent

### Passing Parameters {#parameters}

You can pass data into a component by passing additional parameters into the <code>&#64;livewire</code> directive. For example, let's say we have a `ShowContact` Livewire component that needs to know which contact to show. Here's how you would pass in a `contact` model.

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:show-post :post="$post">
@endverbatim
@endcomponent

Alternatively, this is how you can pass in parameters using the Blade directive.

@component('components.code', ['lang' => 'html'])
@verbatim
@livewire('show-post', ['post' => $post])
@endverbatim
@endcomponent

Now, you can intercept those parameters and store the data as public properties using the `mount()` method.

@component('components.tip')
In Livewire components, you use <code>mount()</code> instead of a class constructor <code>__construct()</code> like you may be used to.
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;

class ShowPost extends Component
{
    public $title;
    public $content;

    public function mount($post)
    {
        $this->title = $post->title;
        $this->content = $post->content;
    }

    ...
}
@endverbatim
@endcomponent

### Dependency Injection {#injecting-parameters}

Like a controller, you can inject dependencies by adding type-hinted parameters before passed-in ones.

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;
use \Illuminate\Session\SessionManager

class ShowPost extends Component
{
    public $title;
    public $content;

    public function mount(SessionManager $session, $post)
    {
        $session->put("post.{$post->id}.last_viewed", now());

        $this->title = $post->title;
        $this->content = $post->content;
    }

    ...
}
@endverbatim
@endcomponent

## As Pages {#route-registration}

If the main content of a page is a Livewire component, you can pass the component directly into a Laravel route:

@component('components.code', ['lang' => 'php'])
@verbatim
Route::get('/post', ShowPosts::class);
@endverbatim
@endcomponent

By default, Livewire will render the `ShowPosts` into a blade component located at: `resources/views/layouts/app.blade.php`

This component should include both the Livewire assets and a `$slot` for Livewire to render into like so:

@component('components.code')
@verbatim
<head>
    @livewireStyles
</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
@endverbatim
@endcomponent

For more information on Laravel components, [visit the documentation](https://laravel.com/docs/blade#components).

### Configuring Different Layouts {#custom-layout}
If you want to specify a different layout file than the default, you can use the `->layout()` and `->slot()` methods on the view instance you return from `render()`.


@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;

class ShowPost extends Component
{
    ...
    public function render()
    {
        return view('livewire.show-post')
            ->layout('layouts.base');
    }
}
@endverbatim
@endcomponent

If you are using a non-default slot in the component, you can also chain on `->slot()`:

@component('components.code', ['lang' => 'php'])
public function render()
{
    return view('livewire.show-posts')
        ->layout('layouts.base')
        ->slot('main');
}
@endcomponent

Alternatively, Livewire supports using traditional Blade layout files with `@@extends`.

Given the following layout file:

@component('components.code')
@verbatim
<head>
    @livewireStyles
</head>
<body>
    @yield('content')

    @livewireScripts
</body>
@endverbatim
@endcomponent

You can configure Livewire to reference it using `->extends()` instead of `->layout()`:

@component('components.code', ['lang' => 'php'])
public function render()
{
    return view('livewire.show-posts')
        ->extends('layouts.app');
}
@endcomponent

If you need to configure the `@@section` for the component to use, you can configure that as well with the `->section()` method:

@component('components.code', ['lang' => 'php'])
public function render()
{
    return view('livewire.show-posts')
        ->extends('layouts.app')
        ->section('body');
}
@endcomponent

### Route Parameters {#route-params}

Often you need to access route parameters inside your controller methods. Because we are no longer using controllers, Livewire attempts to mimick this behavior through it's `mount` method. For example:

**web.php**
@component('components.code', ['lang' => 'php'])
Route::livewire('/contact/{id}', 'show-contact');
@endcomponent

**App\Http\Livewire\ShowContact.php**
@component('components.code', ['lang' => 'php'])
use Livewire\Component;

class ShowContact extends Component
{
    public $contact;

    public function mount($id)
    {
        $this->contact = User::find($id);
    }

    ...
}
@endcomponent

As you can see, the `mount` method in a Livewire component is acting like a controller method would as far as its parameters go. If you visit `/contact/123`, the `$id` variable passed into the `mount` method will contain the value `123`.

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

If you are using PHP 7.4, you can also typehint class properties, and Livewire will automatically route-model bind to them. For example:

Given the following route:
**web.php**
@component('components.code', ['lang' => 'php'])
Route::livewire('/contact/{contact}', ShowContact::class);
@endcomponent

The following component's `$contact` property will be automatically injected with no need for the `mount()` method.

**App\Http\Livewire\ShowContact.php**
@component('components.code', ['lang' => 'php'])
use Livewire\Component;
use App\Contact;

class ShowContact extends Component
{
    public Contact $contact;
}
@endcomponent

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
