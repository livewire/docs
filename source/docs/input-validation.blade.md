---
title: Input Validation
description: todo
extends: _layouts.documentation
section: content
---

# Input Validation

Consider the following Livewire component:

@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        Contact::create(['email' => $this->email]);
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

    <button wire:click="saveContact">Save Contact</button>
</div>
@endverbatim
@endslot
@endcodeComponent

We can add validation to this form almost exactly how you would in a controller. Take a look:

@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = $this->validate([
            'email' => 'required|email',
        ]);

        // Execution doesn't reach here if validation fails.

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

> Note: Livewire exposes the same `$errors` object as Laravel, for more information, reference the [Laravel Docs](https://laravel.com/docs/5.8/validation#quick-displaying-the-validation-errors).

## Custom validators

If you wish to use your own validation system in Livewire, that isn't a problem. Livewire will catch `ValidationException` and provide the errors to the view just like using `$this->validate()`.

For example:
@codeComponent([
    'className' => 'ContactForm',
    'viewName' => 'contact-form.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = Validator::make(
            ['email' => $this->email],
            ['email' => 'required|email'],
            ['required' => 'The :attribute field is required'],
        ])->validate();

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
