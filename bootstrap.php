<?php

use App\Listeners\GenerateSitemap;
use TightenCo\Jigsaw\Jigsaw;
use Illuminate\Support\Facades\Blade;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

/**
 * You can run custom code at different stages of the build process by
 * listening to the 'beforeBuild', 'afterCollections', and 'afterBuild' events.
 *
 * For example:
 *
 * $events->beforeBuild(function (Jigsaw $jigsaw) {
 *     // Your code here
 * });
 */

$events->beforeBuild(function (Jigsaw $jigsaw) {
    $compiler = $jigsaw->app->make(\Illuminate\View\Factory::class)->getEngineResolver()->resolve('blade')->getCompiler();

    $compiler->component('_partials.code', 'code');
    $compiler->component('_partials.code-component', 'codeComponent');
    $compiler->component('_partials.warning', 'warning');
});

$events->afterBuild(GenerateSitemap::class);
