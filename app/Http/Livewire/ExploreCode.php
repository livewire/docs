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

    public function becomeASponsor()
    {
        if (auth()->check()) {
            auth()->user()->uiActions()->firstOrCreate(['type' => UiAction::BECOME_A_SPONSOR_CLICKED]);
        }

        return $this->redirect('https://github.com/sponsors/calebporzio');
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
