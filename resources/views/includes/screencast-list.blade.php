<div class="container mx-auto py-8 px-4" style="max-width: 760px;">
    @foreach ($screencasts as $screencast)
        <div class="flex mb-8 pb-6 {{ $loop->last ? '' : 'border-b' }}">
            <div>
            <a href="/screencasts/{{ $screencast->slug }}" class="block w-24 h-24 rounded-full bg-gray-300 p-6  {{ $screencast->is($activeScreencast ?? null) ? 'text-gray-500 hover:text-gray-500' : 'text-blue-700 hover:text-blue-600' }}" {!! $screencast->is($activeScreencast ?? null) ? '' : 'style="padding-left: 1.75rem;"' !!}">
                    <div class="w-12 h-12">
                        {!! file_get_contents(public_path($screencast->is($activeScreencast ?? null) ? '/img/three-dots.svg' : '/img/play-button.svg')) !!}
                    </div>
                </a>
            </div>
            <div class="pl-4 md:pl-12">
                <h2 class="text-2xl m-0"><a class="text-blue-800" href="/screencasts/{{ $screencast->slug }}">{{ $screencast->title }}</a></h2>
                <div class="font-bold mb-3 text-gray-500 text-sm">
                    <span class="">
                        <svg class="svg inline-block" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ $screencast->duration_in_minutes }}
                    </span>
                </div>
                <p class="m-0 text-gray-700 text-base">{{ $screencast->description }}</p>
            </div>
        </div>
    @endforeach
</div>
