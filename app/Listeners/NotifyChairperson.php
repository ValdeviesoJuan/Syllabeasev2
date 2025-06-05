<?php

namespace App\Listeners;

use App\Events\SyllabusSubmittedToChair;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyChairperson
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SyllabusSubmittedToChair $event): void
    {
    }
}
