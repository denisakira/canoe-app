<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Models\DuplicateFund;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DuplicateFundWarningListener
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
    public function handle(DuplicateFundWarning $event): void
    {
        DuplicateFund::create($event->fund);
    }
}
