---
title: Rendering Components
description: todo
extends: _layouts.documentation
section: content
---

You can include a Livewire component in an existing Blade view with the `@livewire` directive.

Let's assume we have a route like `Route::get('/home', 'HomeController@show')`, and `HomeController` returns a view named `home.blade.php`. We can include a component called `counter` like so:

```php
@extends('layouts.app')

@section('content')

    @livewire('counter')

@endsection
```

### Initial Parameters

Additionally, you can pass data into a component by passing additional parameters into the `@livewire` directive. For example, let's say we have an `ShowContact` Livewire component that needs to know which contact to show. Here's how you would pass in the contact id.

```php
@livewire('show-contact', $contactId)
```

```php
class ShowContact extends LivewireComponent
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
```

You can pass multiple parameters to the `mount()` hook and receive them like so:

```php
@livewire('show-contact', $contactId, $profilePhotoUrl)
```
