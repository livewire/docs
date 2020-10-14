<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UiAction extends Model
{
    const INVITE_SENT = 1;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function markInviteAsSent($user)
    {
        static::firstOrCreate([
            'user_id' => $user->id,
            'type' => static::INVITE_SENT,
        ]);
    }

    public static function hasAlreadySentInvite($user)
    {
        return static::where([
            'user_id' => $user->id,
            'type' => static::INVITE_SENT,
        ])->exists();
    }
}
