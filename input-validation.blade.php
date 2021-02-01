
Validation in Livewire should feel similar to standard form validation in Laravel. In short, Livewire provides a `$rules` property for setting validation rules on a per-component basis, and a `$this->validate()` method for validating a component's properties using those rules.

Here's a simple example of a form in Livewire being validated.

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function submit()
    {
        $this->validate();

        // Execution doesn't reach here if validation fails.

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="submit">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
@endverbatim
@endslot
@endcomponent

If validation fails, a standard `ValidationException` is thrown (and caught by Livewire), and the standard `$errors` object is available inside the component's view. Because of this, any existing code you have, likely a Blade include, for handling validation in the rest of your application will apply here as well.

You can also add custom key/message pairs to the error bag.
@component('components.code', ['lang' => 'php'])
@verbatim
    $this->addError('key', 'message')
@endverbatim
@endcomponent

If you need to define rules dynamically, you can substitute the `$rules` property for the `getRules()` method on the component:

@component('components.code', ['lang' => 'php'])
@verbatim
class ContactForm extends Component
{
    public $name;
    public $email;

    protected function getRules()
    {
        return [
            'name' => 'required|min:6',
            'email' => ['required', 'email', 'not_in:' . auth()->user()->email],
        ];
    }
}
@endverbatim
@endcomponent

## Real-time Validation {#real-time-validation}

Sometimes it's useful to validate a form field as a user types into it. Livewire makes "real-time" validation simple with the `$this->validateOnly()` method.

To validate an input field after every update, we can use Livewire's `updated` hook:

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveContact()
    {
        $validatedData = $this->validate();

        Contact::create($validatedData);
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<form wire:submit.prevent="saveContact">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
@endverbatim
@endslot
@endcomponent

Let's break down exactly what is happening in this example:

* The user types into the "name" field
* As the user types in their name, a validation message is shown if it's less than 6 characters
* The user can switch to entering their email, and the validation message for the name still shows
* When the user submits the form, there is a final validation check, and the data is persisted.

If you are wondering, "why do I need `validateOnly`? Can't I just use `validate`?". The reason is because otherwise, every single update to any field would validate ALL of the fields. This can be a jarring user experience. Imagine if you typed one character into the first field of a form, and all of a sudden every single field had a validation message. `validateOnly` prevents that, and only validates the current field being updated.

## Validating with rules outside of the `$rules` property
If for whatever reason you want to validate using rules other than the ones defined in the `$rules` property, you can always do this by passing the rules directly into the `validate()` and `validateOnly()` methods.

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $name;
    public $email;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
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
}
@endverbatim
@endslot
@endcomponent

## Customize Error Message & Attributes

If you wish to customize the validation messages used by a Livewire component, you can do so with the `$messages` property. 

If you want to keep the default Laravel validation messages, but just customize the `:attribute` portion of the message, you can specify custom attribute names using the `$validationAttributes` property. 

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
    ];

    protected $validationAttributes = [
        'email' => 'email address'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveContact()
    {
        $validatedData = $this->validate();

        Contact::create($validatedData);
    }
}
@endverbatim
@endslot
@endcomponent

If you are not using the global `$rules` validation property, then you can pass custom messages and attributes directly into `validate()`.

@component('components.code-component')
@slot('class')
@verbatim
class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = $this->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'The :attribute cannot be empty.',
                'email.email' => 'The :attribute format is not valid.',
            ],
            ['email' => 'Email Address']
        );

        Contact::create($validatedData);
    }
}
@endverbatim
@endslot
@endcomponent


## Direct Error Message Manipulation {#error-bag-manipulation}

The `validate()` and `validateOnly()` method should handle most cases, but sometimes you may want direct control over Livewire's internal ErrorBag.

Livewire provides a handful of methods for you to directly manipulate the ErrorBag.

From anywhere inside a Livewire component class, you can call the following methods:

@component('components.code', ['lang' => 'php'])
@verbatim
// Quickly add a validation message to the error bag.
$this->addError('email', 'The email field is invalid.');

// These two methods do the same thing, they clear the error bag.
$this->resetErrorBag();
$this->resetValidation();

// If you only want to clear errors for one key, you can use:
$this->resetValidation('email');
$this->resetErrorBag('email');

// This will give you full access to the error bag.
$errors = $this->getErrorBag();
// With this error bag instance, you can do things like this:
$errors->add('some-key', 'Some message');
@endverbatim
@endcomponent

## Testing Validation {#testing-validation}

Livewire provides useful testing utilities for validation scenarios. Let's a write a simple test for the original "Contact Form" component.

@component('components.code', ['lang' => 'php'])
/** @test */
public function name_and_email_fields_are_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', '')
        ->assertHasErrors(['name', 'email']);
}
@endcomponent

This is useful, but we can take it one step further and actually test against specific validation rules:

@component('components.code', ['lang' => 'php'])
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
@endcomponent

Livewire also offers the inverse of `assertHasErrors` -> `assertHasNoErrors()`:

@component('components.code', ['lang' => 'php'])
/** @test */
public function name_field_is_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', 'foo')
        ->assertHasErrors(['name' => 'required'])
        ->assertHasNoErrors(['email' => 'required']);
}
@endcomponent

For more examples of supported syntax for these two methods, take a look at the [Testing Docs](testing).

## Custom validators {#custom-validators}

If you wish to use your own validation system in Livewire, that isn't a problem. Livewire will catch `ValidationException` and provide the errors to the view just like using `$this->validate()`.

For example:
@component('components.code-component')
@slot('class')
@verbatim
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
@endcomponent

@component('components.warning')
You might be wondering if you can use Laravel's "FormRequest"s. Due to the nature of Livewire, hooking into the http request wouldn't make sense. For now, this functionality is not possible or recommended.
@endcomponent
