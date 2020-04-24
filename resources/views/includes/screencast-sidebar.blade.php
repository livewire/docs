<div>
    @php $activeScreencast = $screencast @endphp
    @foreach (App\Series::all() as $series)
        <div class="{{ $loop->first ? '' : 'border-t pt-4' }}">
            <h5 class="text-lg font-semibold text-blue-800">{{ $series->title }}</h5>
            <ul class="list-none">
                @foreach ($series->screencasts as $screencast)
                    <li class="flex justify-between items-center mb-1 rounded-full -mx-1 p-1 pr-2 hover:bg-gray-100 {{ $screencast->is($activeScreencast ?? null) ? 'bg-indigo-500 hover:bg-indigo-500 text-white' : '' }}">
                        <div class="flex items-center">
                            <a href="/screencasts/{{ $screencast->slug }}" style="width: 1.75rem" class="mr-2 rounded-full  {{ $screencast->is($activeScreencast ?? null) ? ' bg-transparent text-white hover:text-white cursor-default' : ' text-indigo-600 hover:text-indigo-700 bg-indigo-100 hover:bg-indigo-200' }}">{!! file_get_contents(public_path($screencast->is($activeScreencast ?? null) ? '/img/three-dots.svg' : '/img/play-button-circle.svg')) !!}</a>
                            <a href="/screencasts/{{ $screencast->slug }}" class="text-xs font-semibold {{ $screencast->is($activeScreencast ?? null) ? 'text-white hover:text-indigo-100' : '' }}">{{ $screencast->title }}</a>
                        </div>
                        <span class="text-xs font-bold {{ $screencast->is($activeScreencast ?? null) ? 'text-white' : 'text-gray-500' }}">{{ $screencast->duration_in_minutes }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
