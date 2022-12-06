* [Paginating Data](#paginating-data)
* [Resetting Pagination After Filtering Data](#resetting-pagination)
* [Multiple paginators on the same page](#multiple-paginators)
* [Using The Bootstrap Pagination Theme](#bootstrap-theme)
* [Using A Custom Pagination View](#custom-pagination-view)

Livewire offers the ability to paginate results within a component. This feature hooks into Laravel's native pagination features, so it should feel like an invisible feature to you.

## Paginating Data {#paginating-data}

Let's say you have a `show-posts` component, but you want to limit the results to 10 posts per page.

You can paginate the results by using the `WithPagination` trait provided by Livewire.

@component('components.code-component')
@slot('class')
@verbatim
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

## Resetting Pagination After Filtering Data {#resetting-pagination}

A common pattern when filtering a paginated result set is to reset the current page to "1" when filtering is applied.

For example, if a user visits page "4" of your data set, then types into a search field to narrow the results, it is usually desireable to reset the page to "1".

Livewire's `WithPagination` trait exposes a `->resetPage()` method to accomplish this.

This method can be used in combination with the `updating/updated` lifecycle hooks to reset the page when certain component data is updated.

An optional page name parameter may be passed through, if the pagination name is set to anything other than `page`.


@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::where('title', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }
}
@endverbatim
@endcomponent

## Multiple paginators on the same page {#multiple-paginators}

Because Livewire hardcodes the `$page` property inside the `WithPagination` trait, there is no way to have two different paginators on the same page because each will be competing for the same property name in the query string of the URL bar.

Here’s an example of two different components that might exist on the same page. By giving the second one (the comments one) a name, Livewire will pick it up and handle everything accordingly.

@component('components.code', ['lang' => 'php'])
class ShowPosts extends Livewire\Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::paginate(10),
        ]);
    }
}
@endcomponent

@component('components.code', ['lang' => 'php'])
class ListPostComments extends Livewire\Component
{
    use WithPagination;

    public Post $post;

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => $post->comments()->paginate(10, ['*'], 'commentsPage'),
        ]);
    }
}
@endcomponent

Now in the query string, both paginators will be represented like so:

@component('components.code', ['lang' => 'html'])
?page=2&commentsPage=3
@endcomponent

To reset a specific paginator, you may pass through your custom page name using the `->resetPage()` method as found in the `WithPagination` trait.

@component('components.code', ['lang' => 'php'])
@verbatim
class ListPostComments extends Livewire\Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage('commentsPage');
    }

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => $post->comments()->where('title', 'like', '%'.$this->search.'%')->paginate(10, ['*'], 'commentsPage'),
        ]);
    }
}
@endverbatim
@endcomponent

## Using The Bootstrap Pagination Theme {#bootstrap-theme}
Like Laravel, Livewire's default pagination view uses Tailwind classes for styling. If you use Bootstrap in your application, you can enable the Bootstrap theme for the pagination view using the `$paginationTheme` property on your component.

@component('components.code', ['lang' => 'php'])
class ShowPosts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
@endcomponent

## Using A Custom Pagination View {#custom-pagination-view}

Livewire provides 3 ways to customize the pagination links Blade view, rendered when calling `$results->links()`.

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

**Method C**: Publish the Livewire pagination views.

You can publish the Livewire pagination views to <code>resources/views/vendor/livewire</code> using the following artisan command:

@component('components.code', ['lang' => 'bash'])
@verbatim
php artisan livewire:publish --pagination
@endverbatim
@endcomponent

@component('components.warning')
Unfortunately, Livewire will overwrite a custom view you have defined inside a service provider using: <code>Paginator::defaultView()</code>.
@endcomponent

When using either method, instead of anchor tags in your pagination component, you should use `wire:click` handlers with the following methods:

- `nextPage` to navigate to the next page
- `previousPage` to navigate to the previous page
- `gotoPage($page)` to navigate to a specific page.

See below for an example of how the default livewire paginator works.

@component('components.code', ['lang' => 'php'])
@verbatim
<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
@endverbatim
@endcomponent
