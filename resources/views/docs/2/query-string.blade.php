
Sometimes it's useful to update the browser's query string when your component state changes.

For example, if you were building a "search posts" component, and wanted the query string to reflect the current search value like so:

`https://your-app.com/search-posts?search=some-search-string`

This way, when a user hits the back button, or bookmarks the page, you can get the initial state out of the query string, rather than resetting the component every time.

In these cases, you can add a property's name to `protected $queryString`, and Livewire will update the query string every time the property value changes, and also update the property when the query string changes.

@component('components.code-component')
@slot('class')
class SearchPosts extends Component
{
    public $search;

    protected $queryString = ['search'];

    public function render()
    {
        return view('livewire.search-posts', [
            'posts' => Post::where('title', 'like', '%'.$this->search.'%')->get(),
        ]);
    }
}
@endslot
@slot('view')
@verbatim
<div>
    <input wire:model="search" type="text" placeholder="Search posts by title...">

    <h1>Search Results:</h1>

    <ul>
        @foreach($posts as $post)
            <li>{{ $post->title }}</li>
        @endforeach
    </ul>
</div>
@endverbatim
@endslot
@endcomponent

### Keeping A Clean Query String {#clean-query-string}

In the case above, when the search property is empty, the query string will look like this:

`?search=`

There are other cases where you might want to only represent a value in the query string if it is NOT the default setting.

For example, if you have a `$page` property to track pagination in a component, you may want to remove the `page` property from the query string when the user is on the first page.

In cases like these, you can use the following syntax:

@component('components.code-component')
@slot('class')
class SearchPosts extends Component
{
    public $foo;
    public $search = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->fill(request()->only('search', 'page'));
    }

    ...
}
@endslot
@endcomponent
