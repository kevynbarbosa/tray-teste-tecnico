<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Services\ApiMarketPlaceService;
use App\States\OfferPendingImagesState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetOfferImagesJob implements ShouldQueue
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
        // (new ApiMarketPlaceService())->getOfferImages($this->offerId); // Sem utilizar State Pattern
        // (new OfferPendingImagesState($this->offer))->execute();
        $this->offer->executeState();
    }
}
