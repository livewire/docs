<?php

use Illuminate\Support\Str;

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Livewire',
    'siteDescription' => 'A full-stack framework for Laravel that makes building dynamic front-ends as easy as writing vanilla PHP (literally).',

    'collections' => [
        'podcasts' => [
            'extends' => '_layouts.podcast',
            'sort' => '-number',
            'items' => function () {
                $simplecast = Simplecast\ClientFactory::factory([
                    'apiKey' => env('SIMPLECAST_API_KEY'),
                ]);

                return collect($simplecast->podcastEpisodes([
                    'podcast_id' => 10939, // Id for "Building Livewire".
                ]))->map(function ($ep) {
                    $idFromSharingUrl = Str::after($ep['sharing_url'], 'https://simplecast.com/s/');

                    return [
                        'number' => $ep['number'],
                        'filename' => 'ep'.$ep['number'].'-'.Str::slug($ep['title']),
                        'title' => $ep['title'],
                        'duration_in_minutes' => date('i:s', $ep['duration']),
                        'published' => $ep['published'],
                        'description' => $ep['description'],
                        'long_description' => $ep['long_description'],
                        'published_on' => Str::before(Carbon\Carbon::parse($ep['published_at'])->format('M d, Y'), ', 2019'),
                        'sharing_url' => $ep['sharing_url'],
                        'iframe_markup' => "<iframe frameborder='0' height='200px' scrolling='no' seamless src='https://embed.simplecast.com/{$idFromSharingUrl}?color=f5f5f5' width='100%'></iframe>"
                    ];
                })->filter(function ($ep) {
                    return $ep['published'] == true;
                });
            },
        ],
    ],

    // Algolia DocSearch credentials
    'docsearchApiKey' => 'cec0554d960fa30b4b0b610f372a8636',
    'docsearchIndexName' => 'livewire-framework',

    // navigation menu
    'navigation' => require_once('navigation.php'),

    // helpers
    'getNextPage' => function ($page) {
        // Before: ['foo' => 'bar', 'baz' => ['children' => ['bob' => 'lob', 'law' => 'blog']]]
        $flattenedArrayOfPagesAndTheirLables = $page->navigation->map(function ($value, $key) {
            $links = is_iterable($value) ? $value['children']->toArray() : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return ['path' => $path, 'label' => $label];
            });
        })
        ->flatten(1);
        // After: [['label' => 'foo', 'path' => 'bar'], ['label' => 'bob', 'path' => 'lob'], ['label' => 'law', 'path' => 'blog']]

        $pathsByIndex = $flattenedArrayOfPagesAndTheirLables->pluck('path');

        $currentIndex = $pathsByIndex->search(trimPath($page->getPath()));

        $nextIndex = $currentIndex + 1;

        return $flattenedArrayOfPagesAndTheirLables[$nextIndex] ?? null;
    },
    'getPreviousPage' => function ($page) {
        // Before: ['foo' => 'bar', 'baz' => ['children' => ['bob' => 'lob', 'law' => 'blog']]]
        $flattenedArrayOfPagesAndTheirLables = $page->navigation->map(function ($value, $key) {
            $links = is_iterable($value) ? $value['children']->toArray() : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return ['path' => $path, 'label' => $label];
            });
        })
        ->flatten(1);
        // After: [['label' => 'foo', 'path' => 'bar'], ['label' => 'bob', 'path' => 'lob'], ['label' => 'law', 'path' => 'blog']]

        $pathsByIndex = $flattenedArrayOfPagesAndTheirLables->pluck('path');

        $currentIndex = $pathsByIndex->search(trimPath($page->getPath()));

        $previousIndex = $currentIndex - 1;

        return $flattenedArrayOfPagesAndTheirLables[$previousIndex] ?? null;
    },
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
    },
];
