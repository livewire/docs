<button
    title="Start searching"
    type="button"
    class="flex md:hidden bg-gray-100 hover:bg-blue-100 justify-center items-center border border-gray rounded-full focus:outline-none h-10 px-3"
    onclick="searchInput.toggle()"
>
    <img src="/assets/img/magnifying-glass.svg" alt="search icon" class="h-4 w-4 max-w-none">
</button>

<div id="js-search-input" class="docsearch-input__wrapper hidden md:block">
    <label for="search" class="hidden">Search</label>

    <input
        id="docsearch-input"
        class="docsearch-input relative block h-10 w-full lg:w-1/2 xl:w-1/3 bg-gray-100 outline-none rounded-full text-gray-700 border border-gray focus:border-blue-400 ml-auto px-4 pb-0"
        style="transition: width .2s;"
        name="docsearch"
        type="text"
        placeholder="Search"
    >

    <button
        class="md:hidden absolute right-0 top-0 h-full font-light text-3xl text-blue-500 hover:text-blue-600 focus:outline-none -mt-1 pr-8"
        onclick="searchInput.toggle()"
    >&times;</button>
</div>

@push('scripts')
    @if ($page->docsearchApiKey && $page->docsearchIndexName)
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>
        <script type="text/javascript">
            window.something = docsearch({
                apiKey: '{{ $page->docsearchApiKey }}',
                indexName: '{{ $page->docsearchIndexName }}',
                inputSelector: '#docsearch-input',
                debug: false // Set debug to true if you want to inspect the dropdown
            });

            const searchInput = {
                toggle() {
                    const menu = document.getElementById('js-search-input');
                    menu.classList.toggle('hidden');
                    menu.classList.toggle('md:block');
                    document.getElementById('docsearch-input').focus();
                },
            }

            document.addEventListener('keydown', (e) => {
                if (e.keyCode == 191) {
                    document.getElementById('docsearch-input').focus();
                    e.preventDefault()
                }
                if (e.keyCode == 27) {
                    document.getElementById('docsearch-input').blur();
                    e.preventDefault()
                }
            })
        </script>
    @endif
@endpush
