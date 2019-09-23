<?php $__env->startSection('content'); ?>
<div style="background: #10B3CB; background-image: linear-gradient(to bottom, rgba(245, 246, 252, 0), rgba(0, 0, 0, 0.2));">
    <div class="container mx-auto px-12 py-12 text-xl flex justify-between items-center" style="max-width: 900px">
        <div class="w-1/2 py-16">
                <h2 class="text-5xl m-0 text-white"><?php echo e($page->title); ?></h2>
                <div class="font-bold mb-3 text-white text-base opacity-75">
                    <span>
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <?php echo e($page->published_on); ?>

                    </span>
                    <span class="ml-3">
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <?php echo e($page->duration_in_minutes); ?>

                    </span>
                </div>
                <p class="m-0 text-base text-white"><?php echo e($page->description); ?></p>
        </div>

        <div class="">
            <?php echo $page->iframe_markup; ?>

        </div>
    </div>
</div>

<div class="container mx-auto py-8" style="max-width: 760px;">
<h3>Transcript:</h3>
<p><?php echo (new TightenCo\Jigsaw\Parsers\ParsedownExtraParser())->parse($page->long_description); ?></p>
</div>
<?php $__env->stopSection(true); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_layouts/podcast.blade.php ENDPATH**/ ?>