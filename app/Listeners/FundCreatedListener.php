<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use App\Services\FundService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FundCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected FundService $fundService,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(FundCreated $event): void
    {
        // check if fund created is a duplicate
        // if it is, dispatch a duplicate_fund_warning event

        $fund = $event->fund;

        if (!$fund) {
            return;
        }

        $hasDuplicate = $this->fundService->hasDuplicate($fund, $fund->fundManager->name);

        if ($hasDuplicate) {
            DuplicateFundWarning::dispatch($fund);
        }
    }
}
