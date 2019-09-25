<?php
$next = $page->getNextPage();
$prev = $page->getPreviousPage();
?>

<div class="flex flex-col-reverse md:flex-row justify-between items-center">
    <div class="flex flex-col items-center md:items-start">
        <?php if($prev): ?>
            <span class="font-black text-gray-500 text-sm tracking-wider uppercase pb-1">← Previous Topic</span>
            <h4 class="font-bold underline m-0 text-blue-700">
                <a href="/<?php echo e($prev['path']); ?>"><?php echo $prev['label']; ?></a>
            </h4>
        <?php endif; ?>
    </div>
    <div class="mb-8 md:mb-0 flex flex-col items-center md:items-end">
        <?php if($next): ?>
            <span class="font-black text-gray-500 text-sm tracking-wider uppercase pb-1">Next Topic →</span>
            <h4 class="font-bold underline m-0 text-blue-700">
                <a href="/<?php echo e($next['path']); ?>"><?php echo $next['label']; ?></a>
            </h4>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_nav/footer-links.blade.php ENDPATH**/ ?>