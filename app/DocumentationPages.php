<?php

namespace App;

class DocumentationPages
{
    public $rows = [
        1 => [
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
                'File Uploads' => 'file-uploads',
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
                'Inline Scripts' => 'inline-scripts',
            ],
            'Testing' => 'testing',
            'Security' => 'security',
            'Troubleshooting' => 'troubleshooting',
            'Package Development' => 'package-dev',
            'Artisan Commands' => 'artisan-commands',
            'API Reference' => 'api',
        ],
        2 => [
            'Quickstart' => 'quickstart',
            'Reference' => 'reference',
            'Upgrading From 1.x' => 'upgrading',
            'The Essentials' => [
                'Installation' => 'installation',
                'Making Components' => 'making-components',
                'Rendering Components' => 'rendering-components',
                'Properties' => 'properties',
                'Actions' => 'actions',
                'Events' => 'events',
                'Lifecycle Hooks' => 'lifecycle-hooks',
                'Nesting Components' => 'nesting-components',
            ],
            'Component Features' => [
                'Validation' => 'input-validation',
                'File Uploads' => 'file-uploads',
                'File Downloads' => 'file-downloads',
                'Query String' => 'query-string',
                'Authorization' => 'authorization',
                'Pagination' => 'pagination',
                'Redirecting' => 'redirecting',
                'Flash Messages' => 'flash-messages',
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
                'Laravel Echo' => 'laravel-echo',
                'Inline Scripts' => 'inline-scripts',
            ],
            'Testing' => 'testing',
            'Troubleshooting' => 'troubleshooting',
            'Package Development' => 'package-dev',
            'Artisan Commands' => 'artisan-commands',
        ],
    ];

    public $currentPage;

    public $currentVersion;

    public function __construct($currentPage = null, $currentVersion = null)
    {
        $this->currentPage = $currentPage;

        $this->currentVersion = intval($currentVersion) ?: $this->newestVersion();
    }

    public function all()
    {
        return $this->rows[$this->currentVersion];
    }

    public function allVersions()
    {
        return array_keys($this->rows);
    }

    public function isActive($compare)
    {
        return $compare === $this->currentPage;
    }

    public function isNewestVersion()
    {
        return $this->newestVersion() === $this->currentVersion;
    }

    public function newestVersion()
    {
        return max($this->allVersions());
    }

    public function title()
    {
        return $this->findTitle($this->all(), $this->currentPage);
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
        $flattenedArrayOfPagesAndTheirDetails = collect($this->all())->map(function ($value, $key) {
            $links = is_array($value) ? $value : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return [
                    'path' => $path,
                    'label' => $label,
                    'version' => $this->currentVersion,
                ];
            });
        })
        ->flatten(1);

        $pathsByIndex = $flattenedArrayOfPagesAndTheirDetails->pluck('path');

        $currentIndex = $pathsByIndex->search($this->currentPage);

        $nextIndex = $currentIndex + 1;

        return $flattenedArrayOfPagesAndTheirDetails[$nextIndex] ?? null;
    }

    public function previous()
    {
        $flattenedArrayOfPagesAndTheirDetails = collect($this->all())->map(function ($value, $key) {
            $links = is_array($value) ? $value : [$key => $value];

            return collect($links)->map(function ($path, $label) {
                return [
                    'path' => $path,
                    'label' => $label,
                    'version' => $this->currentVersion,
                ];
            });
        })
        ->flatten(1);

        $pathsByIndex = $flattenedArrayOfPagesAndTheirDetails->pluck('path');

        $currentIndex = $pathsByIndex->search($this->currentPage);

        $previousIndex = $currentIndex - 1;

        return $flattenedArrayOfPagesAndTheirDetails[$previousIndex] ?? null;
    }
}
