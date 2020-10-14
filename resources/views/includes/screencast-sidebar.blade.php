<div>
    @php $activeScreencast = $screencast @endphp
    @foreach ($series as $s)
        <div class="{{ $loop->first ? '' : 'border-t pt-4' }}">
            <h5 class="text-lg font-semibold text-blue-800">{{ $s->title }}</h5>
            <ul class="list-none">
                @foreach ($s->screencasts as $screencast)
                    <li>
                        <a href="/screencasts/{{ $screencast->slug }}" class="relative group block mb-1 rounded-full overflow-hidden -mx-1 transition-colors duration-200 hover:bg-gray-100 {{ $screencast->is($activeScreencast ?? null) ? 'bg-indigo-500 hover:bg-indigo-500 text-white cursor-default' : '' }}">
                            @if (!$screencast->is($activeScreencast ?? null) && $screencast->last_known_timestamp_in_seconds && ! $screencast->completed_at)
                                <div
                                    class="absolute inset-0 bg-gray-200"
                                    style="width: {{ $screencast->completed_at && !$screencast->last_known_timestamp_in_seconds ? '100' : $screencast->percent_complete }}%"
                                ></div>
                            @endif
                            <div class="relative w-full flex justify-start items-center p-1 pr-2">
                                <span style="width: 1.75rem; height: 1.75rem" class="mr-2 flex items-center justify-center rounded-full flex-shrink-0 transition-colors duration-200
                                    {{ $screencast->is($activeScreencast ?? null) ? ' bg-transparent text-white' : '' }}
                                    {{ $screencast->completed_at && ! $screencast->is($activeScreencast ?? null) ? 'bg-green-100 group-hover:text-indigo-600 group-hover:bg-indigo-100' : ' text-indigo-600 bg-indigo-100' }}
                                ">
                                    @if ($screencast->is($activeScreencast ?? null))
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    @else
                                        @if ($screencast->completed_at)
                                            <svg class="w-4 h-4 text-green-600 group-hover:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif

                                        <svg class="w-6 h-6 {{ $screencast->completed_at ? 'hidden group-hover:block' : '' }}" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke-width="1" stroke="currentColor"></polygon>
                                        </svg>
                                    @endif
                                </span>
                                <span class="text-xs font-semibold {{ $screencast->is($activeScreencast ?? null) ? 'text-white' : '' }}">{{ $screencast->title }}</span>
                                <span class="text-xs font-bold ml-auto {{ $screencast->is($activeScreencast ?? null) ? 'text-white' : 'text-gray-500' }}">{{ $screencast->duration_in_minutes }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
