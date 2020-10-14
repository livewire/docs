<?php

namespace App\Http\Livewire;

use App\UiAction;
use App\Screencast;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ExploreCode extends Component
{
    public $screencast;
    public $hasSentInviteOnCurrentPageLoad = false;

    public function mount(Screencast $screencast)
    {
        $this->screencast = $screencast;
    }

    public function sendInvite()
    {
        Http::withToken(env('GITHUB_TOKEN'))
            ->put('https://api.github.com/repos/livewire/surge/collaborators/'.auth()->user()->github_username, ['permissions' => 'pull']);

        UiAction::markInviteAsSent(auth()->user());

        $this->hasSentInviteOnCurrentPageLoad = true;
    }

    public function render()
    {
        return view('livewire.explore-code');
    }
}
