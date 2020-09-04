<li class="pl-4">
    @if (is_string($item))
        {{-- Menu item with URL--}}
        <a href="/docs/{{ $pages->currentVersion }}.x/{{ $item }}"
            class="{{ 'lvl' . $level }} {{ $pages->isActive($item) ? 'active font-semibold text-blue-600' : '' }} nav-menu__item hover:text-blue-600"
        >
            {!! $label !!}
        </a>
    @else
        {{-- Menu item without URL--}}
        <p class="font-bold nav-menu__item text-gray-500 text-xs tracking-wider uppercase pt-2">{{ $label }}</p>
    @endif

    @if (is_array($item))
        {{-- Recursively handle children --}}
        @include('includes.menu', ['items' => $item, 'level' => ++$level])
    @endif
</li>
