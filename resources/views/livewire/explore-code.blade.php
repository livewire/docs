<div>
    @if ($screencast->code_url)
        <!-- The Screencast has code to show -->
        @if (auth()->user() && auth()->user()->is_sponsor)
            <!-- A guest or a user that hasn't sponsored yet -->
            @if (App\UiAction::hasAlreadySentInvite(auth()->user()))
                <div class="mt-8 -mx-2 flex flex-wrap items-center justify-center lg:justify-start">
                    <div class="p-2">
                        <a class="text-xs md:text-sm border-2 border-indigo-500 cursor-pointer flex hover:border-indigo-800 hover:text-indigo-800 items-center justify-center px-8 py-2 rounded-full text-indigo-600" href="{{ $screencast->code_url }}" target="__blank">
                            <span class="mr-2">Explore The Source Code For This Lesson</span>
                            <svg class="h-4" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        </a>
                    </div>
                    @if (! $hasSentInviteOnCurrentPageLoad)
                        <div class="p-2">
                            <button wire:click="sendInvite" class="inline-flex text-xs font-medium md:text-sm text-gray-600 hover:text-gray-700">
                                Re-send invitation to view the source code
                            </button>
                        </div>
                    @endif
                </div>
            @else
                <div class="mt-8 bg-yellow-200 border-l-4 border-yellow-400 font-medium pl-3 py-2 text-sm text-yellow-700">
                    <div class="font-bold">
                        Explore the source code for this series
                    </div>
                    <div class="mt-1">
                        To get access to the source, you must first be invited to the repository on GitHub.
                    </div>
                    <div class="mt-4">
                        <button wire:click="sendInvite" class="border-2 border-yellow-600 cursor-pointer hover:bg-yellow-300 hover:text-yellow-800 md:text-sm px-4 py-1 rounded-full text-xs">
                            Send Repository Invite
                        </button>
                    </div>
                </div>
            @endif
        @else
            <!-- A guest or a user that hasn't sponsored yet -->
            <div class="mt-8 flex">
                <a href="https://github.com/sponsors/calebporzio" target="__blank" class="text-xs md:text-sm border-2 border-indigo-500 cursor-pointer flex hover:border-indigo-800 hover:text-indigo-800 items-center justify-center px-8 py-2 rounded-full text-indigo-600">
                    <span class="mr-2">Become A Sponsor To Explore The Code</span>
                    <svg class="h-4" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                </a>
            </div>
        @endif
    @endif
</div>
