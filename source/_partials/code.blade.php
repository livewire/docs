<div class="rounded bg-gray-800">
    <pre @isset($lineHighlight) data-line="{{ $lineHighlight }}" @endisset><code class="language-{{ $lang ?? 'html' }}">{{ e($slot) }}</code></pre>
</div>
