<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Livewire',
    'siteDescription' => 'A full-stack framework for Laravel that makes building dynamic front-ends as easy as writing vanilla PHP (literally).',

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
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        return starts_with($path, 'http') ? $path : '/' . trimPath($path);
    },
];
