<div class="flex my-6 py-4 rounded-lg">
    <div class="-ml-16 absolute pr-4 text-blue-500">
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
            class="svg text-4xl"
        >
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
            <circle cx="12" cy="10" r="3"></circle>
        </svg>
    </div>

    <div class="border-l-4 border-blue-400 font-medium pl-4 text-gray-700">
        {{ $slot }}
    </div>
</div>
