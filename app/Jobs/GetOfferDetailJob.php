<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Services\ApiMarketPlaceService;
use App\States\OfferPendingDetailsState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GetOfferDetailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Offer $offer) {}


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // (new ApiMarketPlaceService())->getOfferDetails($this->offerId); // Sem utilizar State Pattern
        (new OfferPendingDetailsState($this->offer))->execute();
    }
}
