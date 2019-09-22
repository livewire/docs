---
title: The <code>mount()</code> method
extends: _layouts.documentation
section: content
---

## Initial Parameters {#initial-params}

You can pass data into a component by passing additional parameters into the `@livewire` directive. For example, let's say we have a `ShowContact` Livewire component that needs to know which contact to show. Here's how you would pass in the contact id.

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

@livewire('show-contact', $contactId)

<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

use Livewire\Component;

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($id)
    {
        $contact = User::find($id);

        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}

<?php echo $__env->renderComponent(); ?>

You can pass multiple parameters to the `mount()` hook and receive them like so:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

@livewire('show-contact', $contactId, $profilePhotoUrl)

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/51cea0619ab62ee788ada3c075294a9d21c9135a.blade.md ENDPATH**/ ?>