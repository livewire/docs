<div class="flex my-6 py-4 rounded-lg">
    <div class="hidden md:block -ml-16 absolute pr-4 text-red-500">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="svg text-5xl"
        >
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12" y2="16"></line>
        </svg>
    </div>

    <div class="border-l-4 border-red-400 font-medium pl-4 text-gray-700">
        {{ $slot }}
    </div>
</div>
