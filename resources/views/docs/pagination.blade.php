
Livewire offers the ability to paginate results within a component. This feature hooks into Laravel's native pagination features, so it should feel like an invisible feature to you.

## Paginating Data

Let's say you have a `show-posts` component, but you want to limit the results to 10 posts per page.

You can paginate the results by using the `WithPagination` trait provided by Livewire.

@component('components.code-component', [
    'className' => 'app/Http/Livewire/ShowPosts.php',
    'viewName' => 'resources/views/livewire/show-posts.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::paginate(10),
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    @foreach ($posts as $post)
        ...
    @endforeach

    {{ $posts->links() }}
</div>
@endverbatim
@endslot
@endcomponent

Now there will be rendered HTML links for the different pages at the bottom of your posts, and the results will be paginated.

## Using A Custom Pagination View {#custom-pagination-view}

Livewire provides 2 ways to customize the pagination links Blade view, rendered when calling `$results->links()`.

**Method A**: Pass view name directly to the `->links()` method.

@component('components.code')
@verbatim
<div>
    @foreach ($posts as $post)
        ...
    @endforeach

    {{ $posts->links('custom-pagination-links-view') }}
</div>
@endverbatim
@endcomponent

**Method B**: Override the `paginationView()` method in your component.

@component('components.code', ['lang' => 'php'])
@verbatim
class ShowPosts extends Component
{
    use WithPagination;

    ...

    public function paginationView()
    {
        return 'custom-pagination-links-view';
    }

    ...
}
@endverbatim
@endcomponent

@component('components.warning')
Unfortunately, Livewire will overwrite a custom view you have defined inside a service provider using: <code>Paginator::defaultView()</code>.
@endcomponent
