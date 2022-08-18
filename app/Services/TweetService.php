<?php

namespace App\Services;

use App\Awards\FollowedOneHundredAccounts;
use App\Events\AwardEarned;
use App\Models\Tweet;
use App\Models\UserFollows;

class TweetService
{
    public function getTweets()
    {
        // AwardEarned::dispatch(new FollowedOneHundredAccounts);

        return Tweet::whereIn(
            'user_id', 
            UserFollows::where(
                'user_id', 
                auth()->user()->id
            )->get()->pluck('id')->push(auth()->user()->id)
        )->with('user')->orderBy('created_at', 'desc')->paginate();
    }

    public function createTweet(string $tweet)
    {
        Tweet::create([
            'tweet' => $tweet,
            'user_id' => auth()->user()->id
        ]);
    }
}