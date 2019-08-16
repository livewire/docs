---
title: Lifecycle Hooks
description: todo
extends: _layouts.documentation
section: content
---

# Lifecycle Hooks

## PHP Hooks

Each Livewire component undergoes a lifecycle (`mount`, `updating`, `updated`). Lifecycle hooks allow you to run code at any part of the component's lifecyle, or before specific properties are updated.

Hooks | Description
--- | ---
mount | Runs immediately after the component is instantiated, but before `render()` is called
updating | Runs before any update to the Livewire component
updated | Runs after any update to the Livewire component
updatingFoo | Runs before a property called `$foo` is updated
updatedFoo | Runs after a property called `$foo` is updated

@code(['lang' => 'php'])
use Livewire\Component;

class HelloWorld extends Component
{
    public $foo;

    public function mount()
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
@endcode

## Javascript Hooks

Livewire gives you the opportunity to execute javascript before and after the DOM updates.

Hooks | Description
--- | ---
beforeDomUpdate | Runs after Livewire receives a response from the server, but before any DOM diffing/patching takes place
afterDomUpdate | Runs after livewire updates the DOM

@code(['lang' => 'js'])
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        window.livewire.beforeDomUpdate(() => {
            // Add your custom JavaScript here.
        });

        window.livewire.afterDomUpdate(() => {
            // Add your custom JavaScript here.
        });
    });
</script>
@endcode
