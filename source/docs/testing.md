# Testing

Livewire supports 2 styles of testing it's components:
1. Unit testing
2. End-to-end testing

For these demonstrations, we will be using a simple Counter component like the following:

<div title="Component"><div title="Component__class">

Counter.php
```php
class Counter extends LivewireComponent
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
```
</div><div title="Component__view">

counter.blade.php
```html
<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
</div>
```
</div></div>

## Unit Testing

```php
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
```

## End-to-end Testing

```php
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
```
