<div class="rounded bg-gray-800">
    <pre @isset($lineHighlight) data-line="{{ $lineHighlight }}" @endisset class="scrollbar-none"><code class="scrolling-touch language-{{ $lang ?? 'html' }}">{{ e($slot) }}</code></pre>
</div>
