---
title: The <code>render()</code> method
extends: _layouts.documentation
section: content
---

A Livewire component class needs only one method to function properly: `render()`. This method fires on every component update and is in charge of returning the Blade view to be rendered.

### Returning Blade {#returning-blade}
The `render()` method is expected to return a Blade view, therefore, you can compare it to writing a controller method. Here is an example:

<?php $__env->startComponent('_partials.tip'); ?>
Make sure your Blade views have only ONE root HTML element.
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code-component', [
    'className' => 'ShowPosts.php',
    'viewName' => 'show-posts.blade.php',
]); ?>
<?php $__env->slot('class'); ?>

use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all(),
        ]);
    }
}

<?php $__env->endSlot(); ?>
<?php $__env->slot('view'); ?>

<div>
    @foreach ($posts as $post)
        @include('includes.post', $post)
    @endforeach
</div>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.warning'); ?>
Although `render()` methods closely resemble controller methods, there are a few techniques you are used to using in controllers that aren't available in Livewire components.

Here are two common things you might forget ARE NOT possible in Livewire:
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('_partials.code', ['lang' => 'php']); ?>

public function render()
{
    return back();
    // Or
    return ['some' => 'data'];
}

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/cache/38eb94535a67e347c2fde5be248f497cfe3da03e.blade.md ENDPATH**/ ?>