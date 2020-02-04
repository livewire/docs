---
title: Testing
extends: _layouts.documentation
section: content
---

Livewire offers a powerful set of tools for testing your components.

For the demonstrations, lets assume a simple Counter component like the following:

@codeComponent([
    'className' => 'Counter.php',
    'viewName' => 'counter.blade.php',
])
@slot('class')
@verbatim
use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $this->count }}</h1>
    <button wire:click="decrement">-</button>
</div>
@endverbatim
@endslot
@endcodeComponent

You can pass data to `Livewire::test()` method to initialize your component properties like so:

@code(['lang' => 'php'])
Livewire::test(Counter::class, $param1, $param2 ...);
@endcode

@code(['lang' => 'php'])
class CounterTest extends TestCase
{
    /** @test */
    function can_increment()
    {
        Livewire::actingAs(factory(User::class)->create())
            ->test(Counter::class)
            ->assertSee(0)
            ->call('increment')
            ->assertSee(1)
            ->call('decrement')
            ->assertSee(0)
            ->set('count', 1)
            ->assertSee(1)
            ->set(['count' => 2])
            ->assertSee(2)
            ->call('emitFoo')
            ->assertEmitted('foo')
            ->call('emitFooWithParam', 'bar')
            ->assertEmitted('foo', 'bar')
            ->call('emitFooWithParam', 'bar')
            ->assertEmitted('foo', function ($event, $params) {
                return $event === 'foo' && $params === ['bar'];
            });
    }
}
@endcode

## All Available Test Methods {#all-testing-methods}

@code(['lang' => 'php'])
Livewire::actingAs($user);
// Set the provided user as the session's logged in user for the test.

Livewire::set('foo', 'bar');
// Set the "foo" property (`public $foo`) to the value: "bar"

Livewire::call('foo');
// Call the "foo" method

Livewire::call('foo', 'bar', 'baz');
// Call the "foo" method, and pass in the parameter "bar", and "baz"

Livewire::assertSet('foo', 'bar');
// Asserts that the "foo" property is set to the value "bar"

Livewire::assertNotSet('foo', 'bar');
// Asserts that the "foo" property is NOT set to the value "bar"

Livewire::assertSee('foo');
// Assert that the string "foo" exists in the currently rendered HTML of the component

Livewire::assertDontSee('foo');
// Assert that the string "foo" DOES NOT exist in the HTML

Livewire::assertEmitted('foo');
// Assert that the "foo" event was emitted

Livewire::assertEmitted('foo', 'bar', 'baz');
// Assert that the "foo" event was emitted with the "bar" and "baz" parameters

Livewire::assertHasErrors('foo');
// Assert that the "foo" property has validation errors

Livewire::assertHasErrors(['foo', 'bar']);
// Assert that the "foo" AND "bar" properties have validation errors

Livewire::assertHasErrors(['foo' => 'required']);
// Assert that the "foo" property has a "required" validation rule error

Livewire::assertHasErrors(['foo' => ['required', 'min']]);
// Assert that the "foo" property has a "required" AND "min" validation rule error

Livewire::assertHasNoErrors('foo');
// Assert that the "foo" property has no validation errors

Livewire::assertHasNoErrors(['foo', 'bar']);
// Assert that the "foo" AND "bar" properties have no validation errors

Livewire::assertNotFound();
// Assert that an error within the component caused an error with the status code: 404

Livewire::assertRedirect('/some-path');
// Assert that a redirect was triggered from the component.

Livewire::assertUnauthorized();
// Assert that an error within the component caused an error with the status code: 401

Livewire::assertForbidden();
// Assert that an error within the component caused an error with the status code: 403

Livewire::assertStatus(500);
// Assert that an error within the component caused an error with the status code: 500

Livewire::assertDispatchedBrowserEvent('event', $data);
// Assert that a browser event was dispatched from the component using (->dispatchBrowserEvent(...))

@endcode
