<?php

namespace App\Jobs;

use App\Services\ApiMarketPlaceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetOfferDetailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $offerId) {}


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new ApiMarketPlaceService())->getOfferDetails($this->offerId);
    }
}
