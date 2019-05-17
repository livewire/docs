<div class="rounded bg-gray-800 overflow-hidden">
    @isset($class)
    <div class="relative py-1">
        @isset($className) <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm">{{ $className }}</span> @endisset
        <pre style="margin: 0"><code class="language-php">{{ e($class) }}</code></pre>
    </div>
    @endisset
    @isset($view)
    <div class="border-gray-700 border-t-2 relative py-1" style="background: hsla(220, 26%, 27%, 1)">
        @isset($viewName) <span class="select-none absolute font-bold px-4 pt-1 right-0 text-gray-500 text-sm">{{ $viewName }}</span> @endisset
        <pre style="margin: 0"><code class="language-html">{{ e($view) }}</code></pre>
    </div>
    @endisset
</div>
