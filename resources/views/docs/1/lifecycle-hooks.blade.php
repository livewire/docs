@include('includes.screencast-cta')

## Class Hooks

Each Livewire component undergoes a lifecycle (`mount`, `updating`, `updated`). Lifecycle hooks allow you to run code at any part of the component's lifecyle, or before specific properties are updated.

@component('components.table')
Hooks | Description
--- | ---
mount | Runs once, immediately after the component is instantiated, but before `render()` is called
hydrate | Runs on every request, immediately after the component is hydrated, but before an action is performed, or `render()` is called
updating | Runs before any update to the Livewire component's data
updated | Runs after any update to the Livewire component's data
updatingFoo | Runs before a property called `$foo` is updated
updatedFoo | Runs after a property called `$foo` is updated
@endcomponent

@component('components.code', ['lang' => 'php'])
use Livewire\Component;

class HelloWorld extends Component
{
    public $foo;

    public function mount()
    {
        //
    }

    public function hydrate()
    {
        //
    }

    public function updating($name, $value)
    {
        //
    }

    public function updatingFoo($value)
    {
        //
    }

    public function updatedFoo($value)
    {
        //
    }

    public function updated($name, $value)
    {
        //
    }
}
@endcomponent

## Javascript Hooks {#js-hooks}

Livewire gives you the opportunity to execute javascript during certain events.

@component('components.table')
Hooks | Description
--- | ---
beforeDomUpdate | Runs after Livewire receives a response from the server, but before any DOM diffing/patching takes place
afterDomUpdate | Runs after livewire updates the DOM
@endcomponent

@component('components.code', ['lang' => 'js'])
<script>
    document.addEventListener("livewire:load", function(event) {
        window.livewire.hook('beforeDomUpdate', () => {
            // Add your custom JavaScript here.
        });

        window.livewire.hook('afterDomUpdate', () => {
            // Add your custom JavaScript here.
        });
    });
</script>
@endcomponent
