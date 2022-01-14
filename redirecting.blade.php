* [Introduction](#introduction)

## Introduction {#introduction}

You may want to redirect from inside a Livewire component to another page in your app. Livewire supports the standard redirect response syntax you are used to using in Laravel controller.

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $email;

    public function addContact()
    {
        Contact::create(['email' => $this->email]);

        return redirect()->to('/contact-form-success');
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
@endcomponent

Now, after the user clicks "Submit" and their contact is added to the database, they will be redirected to the success page (`/contact-form-success`).

@component('components.tip')
Because Livewire works with Laravel's redirection system, you can use any notation you are used to like <code>redirect('/foo')</code>, <code>redirect()->to('/foo')</code>, <code>redirect()->route('foo')</code>.
@endcomponent
