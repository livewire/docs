---
title: Redirecting
description: todo
extends: _layouts.documentation
section: content
---

# Redirecting

You may want to redirect from inside a Livewire component to another route in your app. Livewire offers a simple `$this->redirect()` method to accomplish this:

@codeComponent([
    'className' => 'ContactForm.php',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $email;

    public function addContact()
    {
        Contact::create(['email' => $this->email]);

        $this->redirect('/contact-form-success');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    Email: <input wire:model="email">

    <button wire:click="addContact">Submit</button>
</div>
@endverbatim
@endslot
@endcodeComponent

Now, after the user clicks "Submit" and their contact is added to the database, they will be redirected to the success page (`/contact-form-success`).
