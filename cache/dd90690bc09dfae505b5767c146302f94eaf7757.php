---
title: Testing
extends: _layouts.documentation
section: content
---

Livewire supports 2 styles of testing it's components:
<ol class="list-inside">
    <li>Unit testing</li>
    <li>End-to-end testing</li>
</ol>

For these demonstrations, we will be using a simple Counter component like the following:

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'Counter.php',
    'viewName' => 'counter.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

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

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="decrement">-</button>
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

## Unit Testing {#unit-testing}

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
class CounterTest extends TestCase
{
    /** @test  */
    function can_increment()
    {
        $counter = Livewire::test(Counter::class);

        $this->assertEquals(0, $counter->count);

        $counter->increment();

        $this->assertEquals(1, $counter->count);

        $counter->decrement();

        $this->assertEquals(0, $counter->count);

        $counter->count = 1;

        $this->assertEquals(1, $counter->count);
    }
}
<?php echo $__env->renderComponent(); ?>

You can pass data to `Livewire::test()` method to initialize your component properties like so:

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
$counter = Livewire::test(Counter::class, $param1, $param2 ...);
<?php echo $__env->renderComponent(); ?>

## End-to-end Testing {#end-to-end-testing}

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>
class CounterTest extends TestCase
{
    /** @test  */
    function can_increment()
    {
        Livewire::test(Counter::class)
            ->assertSee(0)
            ->call('increment')
            ->assertSee(1)
            ->call('decrement')
            ->assertSee(0)
            ->set('count', 1)
            ->assertSee(1)
            ->set(['count' => 2])
            ->assertSee(2);
    }
}
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/1e7f95d90d2a44202503ed66877a7c7d817b5f99.blade.md ENDPATH**/ ?>