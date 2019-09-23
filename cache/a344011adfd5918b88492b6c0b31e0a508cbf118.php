<div class="rounded-lg bg-gray-800 overflow-hidden mb-12">
    <?php if(isset($class)): ?>
    <div class="relative py-1">
        <?php if(isset($className)): ?> <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm hidden md:block"><?php echo e($className); ?></span> <?php endif; ?>
        <pre style="margin: 0;" class="scrollbar-none"><code class="scrolling-touch language-php"><?php echo e(e($class)); ?></code></pre>
    </div>
    <?php endif; ?>
    <?php if(isset($view)): ?>
    <div class="border-gray-700 border-t-2 relative py-1">
        <?php if(isset($viewName)): ?> <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm hidden md:block"><?php echo e($viewName); ?></span> <?php endif; ?>
        <pre style="margin: 0;" class="scrollbar-none"><code class="scrolling-touch language-html"><?php echo e(e($view)); ?></code></pre>
    </div>
    <?php endif; ?>
</div>



<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_partials/code-component.blade.php ENDPATH**/ ?>