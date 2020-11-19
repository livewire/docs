PHP Traits are a great way to re-use functionality between multiple Livewire components.

For example, you might have multiple "data table" components in your application that all share the same logic surrounding sorting.

Rather than duplicating the following sorting boilerplate in every component:

@component('components.code-component')
@slot('class')
@verbatim
class ShowPosts extends Component
{
    public $sortBy = '';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    ...
}
@endverbatim
@endslot
@endcomponent

You could instead extract this behavior into a re-usable trait called `WithSorting`:

@component('components.code-component')
@slot('class')
@verbatim
class ShowPosts extends Component
{
    use WithSorting;

    ...
}
@endverbatim
@endslot
@endcomponent

@component('components.code-component')
@slot('class')
@verbatim
trait WithSorting
{
    public $sortBy = '';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort();
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
}
@endverbatim
@endslot
@endcomponent

Additionally, if you want to use Livewire's lifecycle hooks inside your traits but still be able to use them inside your component, Livewire offers a syntax that allows you to do this:

@component('components.code-component')
@slot('class')
@verbatim
trait WithSorting
{
    ...

    public function mountWithSorting()
    {
        //
    }

    public function updatingWithSorting($name, $value)
    {
        //
    }

    public function updatedWithSorting($name, $value)
    {
        //
    }

    public function hydrateWithSorting()
    {
        //
    }

    public function dehydrateWithSorting()
    {
        //
    }

    public function renderingWithSorting()
    {
        //
    }

    public function renderedWithSorting($view)
    {
        //
    }
}
@endverbatim
@endslot
@endcomponent
