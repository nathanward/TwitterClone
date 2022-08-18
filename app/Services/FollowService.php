<?php

namespace App\Services;

use App\Awards\FollowedOneHundredAccounts;
use App\Events\AwardEarned;

class FollowService
{
    public function follow(int $userId)
    {
        $user = auth()->user();

        if ($user->doesFollow($userId)) {
            return;
        }

        $user->follow($userId);

        if ($user->follows()->count() >= 99 && !$user->hasAward(new FollowedOneHundredAccounts)) {
            AwardEarned::dispatch(new FollowedOneHundredAccounts);
        }
    }
}