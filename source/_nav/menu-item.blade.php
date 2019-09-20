<li class="pl-4">
    @if ($url = is_string($item) ? $item : $item->url)
        {{-- Menu item with URL--}}
        <a href="{{ $page->url($url) }}"
            class="{{ 'lvl' . $level }} {{ $page->isActiveParent($item) ? 'lvl' . $level . '-active' : '' }} {{ $page->isActive($url) ? 'active font-semibold text-blue-600' : '' }} nav-menu__item hover:text-blue-600"
        >
            {!! $label !!}
        </a>
    @else
        {{-- Menu item without URL--}}
        <p class="font-bold nav-menu__item text-gray-500 text-xs tracking-wider uppercase pt-2">{{ $label }}</p>
    @endif

    @if (! is_string($item) && $item->children)
        {{-- Recursively handle children --}}
        @include('_nav.menu', ['items' => $item->children, 'level' => ++$level])
    @endif
</li>
