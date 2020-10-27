
Run the following artisan command to create a new Livewire component:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire ShowPosts
@endcomponent

Livewire also supports "kebab" notation for new components.

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire show-posts
@endcomponent

Two new files were created in your project:

* `app/Http/Livewire/ShowPosts.php`
* `resources/views/livewire/show-posts.blade.php`

If you wish to create components within sub-folders, you can use the following different syntaxes:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire Post\\Show
php artisan make:livewire Post/Show
php artisan make:livewire post.show
@endcomponent

Now, the two created files will be in sub-folders:

* `app/Http/Livewire/Post/Show.php`
* `resources/views/livewire/post/show.blade.php`

## Inline Components
If you wish to create Inline components (Component's without `.blade.php` files), you can add the `--inline` flag to the command:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire ShowPosts --inline
@endcomponent

Now, only one file will be created:

* `app/Http/Livewire/ShowPosts.php`

Here's what it would look like:

@component('components.code', ['lang' => 'php'])
@verbatim
class ShowPosts extends Component
{
    public function render()
    {
        return <<<'blade'
            <div></div>
        blade;
    }
}
@endverbatim
@endcomponent
