<?php

namespace App\Awards;

class FollowedOneHundredAccounts extends Award
{
    public function __construct()
    {
        $this->id = 1;
        $this->name = 'Followed one hundred accounts';
        $this->description = 'You have followed one hundred accounts';
    }
}