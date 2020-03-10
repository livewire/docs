@php $level = $level ?? 0 @endphp

<ul class="list-none my-0">
    @foreach ($items as $label => $item)
        @include('includes.menu-item')
    @endforeach
</ul>
