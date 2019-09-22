<?php $__env->startSection('nav-toggle'); ?>
    <?php echo $__env->make('_nav.menu-toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="container mx-auto px-6 md:px-8 py-12">
    <div class="flex flex-col lg:flex-row">
        <nav id="js-nav-menu" class="nav-menu hidden lg:block">
            <?php echo $__env->make('_nav.menu', ['items' => $page->navigation], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>

        <div class="w-full lg:w-3/5 break-words lg:pl-4" v-pre>
            <h1><?php echo $page->title; ?></h1>

            <?php echo $__env->yieldContent('content'); ?>

            <div class="mt-12 pt-8 pb-6 border-t-2">
                <?php echo $__env->make('_nav.footer-links', ['items' => $page->navigation], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(true); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_layouts/documentation.blade.php ENDPATH**/ ?>