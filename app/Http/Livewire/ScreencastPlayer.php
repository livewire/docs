<?php

namespace App\Http\Livewire;

use App\UiAction;
use App\Screencast;
use Livewire\Component;
use App\ScreencastProgress;

class ScreencastPlayer extends Component
{
    public $screencast;
    public $screencastProgress;

    public function mount(Screencast $screencast)
    {
        $this->screencast = $screencast;

        if (auth()->check()) {
            $this->screencastProgress = ScreencastProgress::firstOrCreate([
                'screencast_id' => $this->screencast->id,
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function becomeASponsor()
    {
        if (auth()->check()) {
            auth()->user()->uiActions()->firstOrCreate(['type' => UiAction::BECOME_A_SPONSOR_CLICKED]);
        }

        return $this->redirect('https://github.com/sponsors/calebporzio');
    }

    public function updateLastKnownTimestamp($seconds)
    {
        if (! $this->screencastProgress) {
            return;
        }

        $this->screencastProgress->last_known_timestamp_in_seconds = $seconds;
        $this->screencastProgress->save();
    }

    public function completed()
    {
        if (! $this->screencastProgress) {
            return;
        }

        $this->screencastProgress->completed_at = now();
        $this->screencastProgress->last_known_timestamp_in_seconds = 0;
        $this->screencastProgress->save();
    }

    public function render()
    {
        return view('livewire.screencast-player');
    }
}
