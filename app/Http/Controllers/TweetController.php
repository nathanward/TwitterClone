<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use App\Http\Requests\CreateTweetRequest;

class TweetController extends Controller
{
    private $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function index()
    {
        return view('tweets', ['tweets' => $this->tweetService->getTweets()]);
    }

    public function store(CreateTweetRequest $request)
    {
        $data = $request->validated();

        $this->tweetService->createTweet($data['tweet']);

        return redirect('/tweets');
    }
}