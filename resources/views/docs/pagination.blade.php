
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

When using either method, instead of achor tags in your pagination component, you should use `wire:click` handlers with the following methods:

- `nextPage` to navigate to the next page
- `previousPage` to navigate to the previous page
- `gotoPage($page)` to navigate to a specific page. 

See below for an example of how the default livewire paginator works.

@component('components.code', ['lang' => 'php'])
@verbatim
@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">
                    <span class="d-none d-md-block">&lsaquo;</span>
                    <span class="d-block d-md-none">@lang('pagination.previous')</span>
                </span>
            </li>
        @else
            <li class="page-item">
                <button type="button" class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="d-none d-md-block">&lsaquo;</span>
                    <span class="d-block d-md-none">@lang('pagination.previous')</span>
                </button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled d-none d-md-block" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active d-none d-md-block" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item d-none d-md-block"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button type="button" class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">
                    <span class="d-block d-md-none">@lang('pagination.next')</span>
                    <span class="d-none d-md-block">&rsaquo;</span>
                </button>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">
                    <span class="d-block d-md-none">@lang('pagination.next')</span>
                    <span class="d-none d-md-block">&rsaquo;</span>
                </span>
            </li>
        @endif
    </ul>
@endif
@endverbatim
@endcomponent
