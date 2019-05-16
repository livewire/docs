<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="<?php echo e($page->description ?? $page->siteDescription); ?>">

        <meta property="og:site_name" content="<?php echo e($page->siteName); ?>"/>
        <meta property="og:title" content="<?php echo e($page->title ?  $page->title . ' | ' : ''); ?><?php echo e($page->siteName); ?>"/>
        <meta property="og:description" content="<?php echo e($page->description ?? $page->siteDescription); ?>"/>
        <meta property="og:url" content="<?php echo e($page->getUrl()); ?>"/>
        <meta property="og:image" content="/assets/img/logo.png"/>
        <meta property="og:type" content="website"/>

        <meta name="twitter:image:alt" content="<?php echo e($page->siteName); ?>">
        <meta name="twitter:card" content="summary_large_image">

        <?php if($page->docsearchApiKey && $page->docsearchIndexName): ?>
            <meta name="generator" content="tighten_jigsaw_doc">
        <?php endif; ?>

        <title><?php echo e($page->siteName); ?><?php echo e($page->title ? ' | ' . $page->title : ''); ?></title>

        <link rel="home" href="<?php echo e($page->baseUrl); ?>">
        <link rel="icon" href="/favicon.ico">

        <?php echo $__env->yieldPushContent('meta'); ?>

        <?php if($page->production): ?>
            <!-- Insert analytics code here -->
        <?php endif; ?>

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(mix('css/main.css', 'assets/build')); ?>">

        <?php if($page->docsearchApiKey && $page->docsearchIndexName): ?>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css" />
        <?php endif; ?>
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-gray-200 text-gray-800 leading-normal font-sans">
        <header class="flex items-center h-24 mb-8 py-4" role="banner">
            <div class="container flex items-center mx-auto px-4 lg:px-8">
                <div class="flex items-center">
                    <a href="/" title="<?php echo e($page->siteName); ?> home" class="inline-flex items-center">
                        <img class="h-8 md:h-10 mr-3" src="/assets/img/logo.svg" alt="<?php echo e($page->siteName); ?> logo" />
                    </a>
                </div>

                <div class="flex flex-1 justify-end items-center text-right md:pl-10">
                    <?php if($page->docsearchApiKey && $page->docsearchIndexName): ?>
                        <?php echo $__env->make('_nav.search-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $__env->yieldContent('nav-toggle'); ?>
        </header>

        <main role="main" class="w-full flex-auto">
            <?php echo $__env->yieldContent('body'); ?>
        </main>

        <script src="<?php echo e(mix('js/main.js', 'assets/build')); ?>"></script>

        <?php echo $__env->yieldPushContent('scripts'); ?>

        <footer class="bg-white text-center text-sm mt-12 py-4" role="contentinfo">
            <ul class="flex flex-col md:flex-row justify-center">
                <li class="md:mr-2">
                    &copy; <a href="https://tighten.co" title="Tighten website">Tighten</a> <?php echo e(date('Y')); ?>.
                </li>

                <li>
                    Built with <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten">Jigsaw</a>
                    and <a href="https://tailwindcss.com" title="Tailwind CSS, a utility-first CSS framework">Tailwind CSS</a>.
                </li>
            </ul>
        </footer>
    </body>
</html>
<?php /**PATH /Users/calebporzio/Documents/Code/sites/livewire-docs/source/_layouts/master.blade.php ENDPATH**/ ?>