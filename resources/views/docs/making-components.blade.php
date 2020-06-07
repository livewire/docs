
Run the following artisan command to create a new Livewire component:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire search-posts
@endcomponent

Two new files were created in your project:

* `app/Http/Livewire/SearchPosts.php`
* `resources/views/livewire/search-posts.blade.php`

If you wish to create components within folders, you can use dot-notation:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire post.search
@endcomponent

Now, the two created files will be in sub-folders:

* `app/Http/Livewire/Post/Search.php`
* `resources/views/livewire/post/search.blade.php`

## Inline Components
If you wish to create Inline components (Component's without `.blade.php` files), you can add the `--inline` flag to the command:

@component('components.code', ['lang' => 'bash'])
php artisan make:livewire search-posts --inline
@endcomponent

Now, only one file will be created:

* `app/Http/Livewire/SearchPosts.php`
