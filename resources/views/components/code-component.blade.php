<div class="rounded-lg bg-gray-800 overflow-hidden mb-12">
    @isset($class)
    <div class="relative py-1">
        @isset($className) <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm hidden md:block">{{ $className }}</span> @endisset
        <pre style="margin: 0;" class="scrollbar-none"><code class="scrolling-touch language-php">{{ e($class) }}</code></pre>
    </div>
    @endisset
    @isset($view)
    <div class="border-gray-700 border-t-2 relative py-1">
        @isset($viewName) <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm hidden md:block">{{ $viewName }}</span> @endisset
        <pre style="margin: 0;" class="scrollbar-none"><code class="scrolling-touch language-html">{{ e($view) }}</code></pre>
    </div>
    @endisset
</div>


{{--
@component('components.code-component', [
    'className' => '',
    'viewName' => '',
])
@slot('class')
@verbatim
@endverbatim
@endslot
@slot('view')
@verbatim
@endverbatim
@endslot
@endcomponent
--}}
