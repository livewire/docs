* [Introduction](#introduction)
* [Keeping Track Of Components In A Loop](#keyed-components)
    * [Sibling Components in a Loop](#sibling-components-in-a-loop)

## Introduction {#introduction}

Livewire supports nesting components. Component nesting can be an extremely powerful technique, but there are a few gotchas worth mentioning up-front:

1. Nested components CAN accept data parameters from their parents, HOWEVER they are not reactive like props from a Vue component.
2. Livewire components should NOT be used for extracting Blade snippets into separate files. For these cases, Blade includes or components are preferable.

Here is an example of a nested component called `add-user-note` from another Livewire component's view.

@component('components.code-component')
@slot('class')
@verbatim
class UserDashboard extends Component
{
    public User $user;
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div>
    <h2>User Details:</h2>
    Name: {{ $user->name }}
    Email: {{ $user->email }}

    <h2>User Notes:</h2>
    <div>
        @livewire('add-user-note', ['user' => $user])
    </div>
</div>
@endverbatim
@endslot
@endcomponent

## Keeping Track Of Components In A Loop {#keyed-components}

Similar to VueJs, if you render a component inside a loop, Livewire has no way of keeping track of which one is which. To remedy this, livewire offers a special "key" syntax:

@component('components.code-component')
@slot('view')
@verbatim
<div>
    @foreach ($users as $user)
        @livewire('user-profile', ['user' => $user], key($user->id))
    @endforeach
</div>
@endverbatim
@endslot
@endcomponent

If you are on Laravel 7 or above, you can use the tag syntax.

@component('components.code-component')
@slot('view')
@verbatim
<div>
    @foreach ($users as $user)
        <livewire:user-profile :user="$user" :wire:key="$user->id">
    @endforeach
</div>
@endverbatim
@endslot
@endcomponent

### Sibling Components in a Loop {#sibling-components-in-a-loop}

In some situations, you may find the need to have sibling components inside of a loop, this situation requires additional consideration for the `wire:key` value.

Each component will need its own unique `wire:key`, but using the method above will lead to both sibling components having the same key, which will cause unforeseen issues. To combat this, you could ensure that each `wire:key` is unique by prefixing it with the component name, for example:

@component('components.code', ['lang' => 'blade'])
@verbatim
<!-- user-profile component -->
<div>
    // Bad
    <livewire:user-profile-one :user="$user" :wire:key="$user->id">
    <livewire:user-profile-two :user="$user" :wire:key="$user->id">

    // Good
    <livewire:user-profile-one :user="$user" :wire:key="'user-profile-one-'.$user->id">
    <livewire:user-profile-two :user="$user" :wire:key="'user-profile-two-'.$user->id">
</div>
@endverbatim
@endcomponent
