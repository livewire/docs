---
title: Redirecting
extends: _layouts.documentation
section: content
---

You may want to redirect from inside a Livewire component to another route in your app. Livewire offers two methods to achieve this; a built in `$this->redirect()` method and support for Laravel redirects:

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'ContactForm.php',
    'viewName' => 'contact-form.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

use Livewire\Component;

class ContactForm extends Component
{
    public $email;

    public function addContact()
    {
        Contact::create(['email' => $this->email]);

        $this->redirect('/contact-form-success');

        // Or

        return redirect()->to('/contact-form-success');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    Email: <input wire:model="email">

    <button wire:click="addContact">Submit</button>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

Now, after the user clicks "Submit" and their contact is added to the database, they will be redirected to the success page (`/contact-form-success`).

<?php $__env->startComponent('_partials.tip'); ?>
Because Livewire works with Laravel's redirection system, you can use any notation you are used to like <code>redirect('/foo')</code>, <code>redirect()->to('/foo')</code>, <code>redirect()->route('food')</code>.
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/e3fd5ce969ff3853a2f6c10668837d725b5f88ee.blade.md ENDPATH**/ ?>