<?php

namespace App;

class DocumentationPages
{
    protected $pages = [
        'Quickstart' => 'quickstart',
        'The Essentials' => [
            'Installation' => 'installation',
            'Making Components' => 'making-components',
            'Rendering Components' => 'rendering-components',
            'Properties' => 'properties',
            'Actions' => 'actions',
            'Events' => 'events',
            'Lifecycle Hooks' => 'lifecycle-hooks',
        ],
        'Component Features' => [
            'Validation' => 'input-validation',
            'Authorization' => 'authorization',
            'Pagination' => 'pagination',
            'Redirecting' => 'redirecting',
            'Flash Messages' => 'flash-messages',
            'Nesting Components' => 'nesting-components',
        ],
        'UI Niceties' => [
            'Loading States' => 'loading-states',
            'Polling' => 'polling',
            'Prefetching' => 'prefetching',
            'Offline State' => 'offline-state',
            'Dirty States' => 'dirty-states',
            'Defer Loading' => 'defer-loading',
        ],
        'JS Integrations' => [
            'AlpineJS' => 'alpine-js',
            'Turbolinks' => 'turbolinks',
            'Laravel Echo' => 'laravel-echo',
        ],
        'Testing' => 'testing',
        'Security' => 'security',
        'Troubleshooting' => 'troubleshooting',
        'Package Development' => 'package-dev',
        'Artisan Commands' => 'artisan-commands',
        'API Reference' => 'api',
    ];

    protected $currentUri;

    public function __construct($uri)
    {
        $this->currentUri = $uri;
    }

    public function all()
    {
        return $this->pages;
    }

    public function isActive($compare)
    {
        return $compare === $this->currentUri;
    }

    public function title()
    {
        return $this->findTitle($this->pages, $this->currentUri);
    }

    protected function findTitle($navigation, $slug) {
        foreach ($navigation as $title => $uri) {
            if (is_array($uri)) {
                $foo = $this->findTitle($uri, $slug);
                if ($foo) return $foo;
            }

            if ($uri == $slug) return $title;
        }
    }

    public function next()
    {
        $flattenedArrayOfPagesAndTheirLables = collect($this->pages)->map(function ($value, $key) {
            $links = is_array($value) ? $value : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return ['path' => $path, 'label' => $label];
            });
        })
        ->flatten(1);

        $pathsByIndex = $flattenedArrayOfPagesAndTheirLables->pluck('path');

        $currentIndex = $pathsByIndex->search($this->currentUri);

        $nextIndex = $currentIndex + 1;

        return $flattenedArrayOfPagesAndTheirLables[$nextIndex] ?? null;
    }

    public function previous()
    {
        $flattenedArrayOfPagesAndTheirLables = collect($this->pages)->map(function ($value, $key) {
            $links = is_array($value) ? $value : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return ['path' => $path, 'label' => $label];
            });
        })
        ->flatten(1);

        $pathsByIndex = $flattenedArrayOfPagesAndTheirLables->pluck('path');

        $currentIndex = $pathsByIndex->search($this->currentUri);

        $previousIndex = $currentIndex - 1;

        return $flattenedArrayOfPagesAndTheirLables[$previousIndex] ?? null;
    }
}
