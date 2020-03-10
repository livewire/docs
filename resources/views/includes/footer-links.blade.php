<?php
$next = $pages->next();
$prev = $pages->previous();
?>

<div class="flex flex-col-reverse md:flex-row justify-between items-center">
    <div class="flex flex-col items-center md:items-start">
        @if ($prev)
            <span class="font-black text-gray-500 text-sm tracking-wider uppercase pb-1">← Previous Topic</span>
            <h4 class="font-bold underline m-0 text-blue-700">
                <a href="/docs/{{ $prev['path'] }}">{!! $prev['label'] !!}</a>
            </h4>
        @endif
    </div>
    <div class="mb-8 md:mb-0 flex flex-col items-center md:items-end">
        @if ($next)
            <span class="font-black text-gray-500 text-sm tracking-wider uppercase pb-1">Next Topic →</span>
            <h4 class="font-bold underline m-0 text-blue-700">
                <a href="/docs/{{ $next['path'] }}">{!! $next['label'] !!}</a>
            </h4>
        @endif
    </div>
</div>
