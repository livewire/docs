---
title: Form Validation
extends: _layouts.documentation
section: content
---

Validation in Livewire should feel similar to standard form validation in Laravel.

Here's a simple example of a form in Livewire being validated.

@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;

    public function submit()
    {
        $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email',
        ]);

        // Execution doesn't reach here if validation fails.

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
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
<form wire:submit="submit">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
@endverbatim
@endslot
@endcodeComponent

If validation fails, a standard `ValidationException` is thrown (and caught by Livewire), and the standard `$errors` object is available inside the component's view. Because of this, any existing code you have, likely a Blade include, for handling validation in the rest of your application will apply here as well.

## Real-time Validation {#real-time-validation}

Sometimes it's useful to validate a form field as a user types into it. Livewire makes "real-time" validation simple with the `$this->validateOnly()` method.

To validate an input field after every update, we can use Livewire's `updated` hook:

@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'min:6',
            'email' => 'email',
        ]);
    }

    public function saveContact()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email',
        ]);

        Contact::create($validatedData);
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
<form wire:submit="submit">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
@endverbatim
@endslot
@endcodeComponent

Let's break down exactly what is happening in this example:
* The user types into the "name" field
* As the user types in their name, a validation message is shown if it's less than 6 characters
* The user can switch to entering their email, and the validation message for the name still shows
* When the user submits the form, there is a final validation check, and the data is persisted.

If you are wondering, "why do I need `validateOnly`? Can't I just use `validate`?". The reason is because otherwise, every single update to any field would validate ALL of the fields. This can be a jarring user experience. Imagine if you typed one character into the first field of a form, and all of a sudden every single field had a validation message. `validateOnly` prevents that, and only validates the current field being updated.

## Testing Validation {#testing-validation}

Livewire provides useful testing utilities for validation scenarios. Let's a write a simple test for the original "Contact Form" component.

@code(['lang' => 'php'])
/** @test */
public function name_and_email_fields_are_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', '')
        ->assertHasErrors(['name', 'email']);
}
@endcode

This is useful, but we can take it one step further and actually test against specific validation rules:

@code(['lang' => 'php'])
/** @test */
public function name_and_email_fields_are_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', '')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'required',
        ]);
}
@endcode

Livewire also offers the inverse of `assertHasErrors` -> `assertHasNoErrors()`:

@code(['lang' => 'php'])
/** @test */
public function name_field_is_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', 'foo')
        ->assertHasErrors(['name' => 'required'])
        ->assertHasNoErrors(['email' => 'required']);
}
@endcode

For more examples of supported syntax for these two methods, take a look at the [Testing Docs](/docs/testing).

## Custom validators {#custom-validators}

If you wish to use your own validation system in Livewire, that isn't a problem. Livewire will catch `ValidationException` and provide the errors to the view just like using `$this->validate()`.

For example:
@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = Validator::make(
            ['email' => $this->email],
            ['email' => 'required|email'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        Contact::create($validatedData);
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
    Email: <input wire:model.lazy="email">

    @if($errors->has('email'))
        <span>{{ $errors->first('email') }}</span>
    @endif

    <button wire:click="saveContact">Save Contact</button>
</div>
@endverbatim
@endslot
@endcodeComponent

@warning
You might be wondering if you can use Laravel's "FormRequest"s. Due to the nature of Livewire, hooking into the http request wouldn't make sense. For now, this functionality is not possible or recommended.
@endwarning
