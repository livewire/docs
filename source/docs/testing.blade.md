---
title: Testing
description: todo
extends: _layouts.documentation
section: content
---

# Testing

Livewire supports 2 styles of testing it's components:
1. Unit testing
2. End-to-end testing

For these demonstrations, we will be using a simple Counter component like the following:

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
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
</div>
@endverbatim
@endslot
@endcodeComponent

## Unit Testing

@code(['lang' => 'php'])
class CounterTest extends TestCase
{
    /** @test */
    function can_increment()
    {
        $counter = Livewire::test(Counter::class);

        $this->assertEquals(1, $counter->count);

        $counter->increment();

        $this->assertEquals(2, $counter->count);

        $counter->decrement();

        $this->assertEquals(1, $counter->count);
    }
}
@endcode

## End-to-end Testing

@code(['lang' => 'php'])
class CounterTest extends TestCase
{
    /** @test */
    function can_increment()
    {
        Livewire::test(Counter::class)
            ->assertSee(1)
            ->runAction('increment')
            ->assertSee(2)
            ->runAction('decrement')
            ->assertSee(1);
    }
}
@endcode
