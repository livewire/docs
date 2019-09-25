<li class="pl-4">
    <?php if($url = is_string($item) ? $item : $item->url): ?>
        
        <a href="<?php echo e($page->url($url)); ?>"
            class="<?php echo e('lvl' . $level); ?> <?php echo e($page->isActiveParent($item) ? 'lvl' . $level . '-active' : ''); ?> <?php echo e($page->isActive($url) ? 'active font-semibold text-blue-600' : ''); ?> nav-menu__item hover:text-blue-600"
        >
            <?php echo $label; ?>

        </a>
    <?php else: ?>
        
        <p class="font-bold nav-menu__item text-gray-500 text-xs tracking-wider uppercase pt-2"><?php echo e($label); ?></p>
    <?php endif; ?>

    <?php if(! is_string($item) && $item->children): ?>
        
        <?php echo $__env->make('_nav.menu', ['items' => $item->children, 'level' => ++$level], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</li>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_nav/menu-item.blade.php ENDPATH**/ ?>