<?php

namespace App\Http\Controllers;

use App\Services\FollowService;

class FollowController extends Controller
{
    private $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function follow(int $userId)
    {
        $this->followService->follow($userId);

        return redirect('/tweets');
    }
}