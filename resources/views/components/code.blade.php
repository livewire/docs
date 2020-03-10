<div class="rounded-lg bg-gray-800 mb-12">
    <pre @isset($lineHighlight) data-line="{{ $lineHighlight }}" @endisset class="scrollbar-none"><code class="scrolling-touch language-{{ $lang ?? 'html' }}">{{ e($slot) }}</code></pre>
</div>
