<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Services\ApiMarketPlaceService;
use App\States\OfferPendingPriceState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetOfferPriceJob implements ShouldQueue
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
        // (new ApiMarketPlaceService())->getOfferPrice($this->offerId); // Sem utilizar State Pattern
        (new OfferPendingPriceState($this->offer))->execute();
    }
}
