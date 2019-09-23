<div class="rounded-lg bg-gray-800 mb-12">
    <pre <?php if(isset($lineHighlight)): ?> data-line="<?php echo e($lineHighlight); ?>" <?php endif; ?> class="scrollbar-none"><code class="scrolling-touch language-<?php echo e($lang ?? 'html'); ?>"><?php echo e(e($slot)); ?></code></pre>
</div>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_partials/code.blade.php ENDPATH**/ ?>