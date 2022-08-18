<?php

namespace App\Listeners;

use App\Events\AwardEarned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAwardToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AwardEarned  $event
     * @return void
     */
    public function handle(AwardEarned $event)
    {
        auth()->user()->addAward($event->award);
    }
}
