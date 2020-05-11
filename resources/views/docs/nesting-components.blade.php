
Livewire supports nesting components. Component nesting can be an extremely powerful technique, but there are a few gotchas worth mentioning up-front:

1. Nested components CAN accept data parameters from their parents, HOWEVER they are not reactive like props from a Vue component.
2. Livewire components should NOT be used for extracting Blade snippets into separate files. For these cases, Blade includes or components are preferable.

Here is an example of a nested component called `add-user-note` from another Livewire component's view.

@component('components.code-component', [
    'className' => 'UserDashboard.php',
    'viewName' => 'user-dashboard.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class UserDashboard extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
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

@component('components.code-component', ['viewName' => 'show-users.blade.php'])
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

@component('components.code-component', ['viewName' => 'show-users.blade.php'])
@slot('view')
@verbatim
<div>
    @foreach ($users as $user)
        <livewire:user-profile :user="$user" :key="$user->id">
    @endforeach
</div>
@endverbatim
@endslot
@endcomponent

### Sibling Components in a Loop

In some situations, you may find the need to have sibling components inside of a loop, this situation reqires additional consideration for the `key` value.

Each component will need its own `key` directive, using the method above will lead to both sibling components having the same key, which will cause unforeseen issues.  The solution is to ensure that each sibling component has a truly unique key, one possible technique is to multiply the ID of the model by a random integer, for example:

```php
// user-profile component
<div>    
    // Bad
    <livewire:user-profile-additional-component :user="$user" :key="$user->id">
    <livewire:user-profile-some-related-component :user="$user" :key="$user->id">
    
    // Good
    <livewire:user-profile-additional-component :user="$user" :key="(rand() * $user->id)">
    <livewire:user-profile-some-related-component :user="$user" :key="(rand() * $user->id)">
</div>
```

