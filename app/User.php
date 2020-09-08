<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function sponsor()
    {
         return $this->hasOne(Sponsor::class, 'username', 'github_username');
    }

    public function getIsSponsorAttribute()
    {
        if (in_array($this->github_username, [
            'calebporzio',
            'calebporzio-test',
            // Gift
            'foremtehan',
            // DevSquad
            'r2luna',
            'danieldevsquad',
            // Kevin
            'iAmKevinMcKee',
            // Neerav Pandya
            'neeravp',
            'RicardoRamirezR',
            'ngcammayo',
            'mohsenbostan',
            'mitchjam',
            'amirzpr',
        ])) return true;

        if ($this->sponsor) {
            return $this->sponsor->getsScreencasts();
        }

        return false;
    }

    public function uiActions()
    {
        return $this->hasMany(UiAction::class);
    }
}
