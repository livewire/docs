# Redirecting

You may want to redirect from inside a Livewire component to another route in your app. Livewire offers a simple `$this->redirect()` method to accomplish this:

<div title="Component"><div title="Component__class">

ContactForm.php
```php
class ContactForm extends LivewireComponent
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
```
</div>
<div title="Component__view">

contact-form.blade.php
```html
<div>
    Email: <input wire:model="email">

    <button wire:click="addContact">Submit</button>
</div>
```
</div>
</div>

Now, after the user clicks "Submit" and their contact is added to the database, they will be redirected to the success page (`/contact-form-success`).
