<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetOffersJob implements ShouldQueue
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
        GetOfferDetailJob::dispatch($this->offerId);
        GetOfferImagesJob::dispatch($this->offerId);
        GetOfferPriceJob::dispatch($this->offerId);
    }
}
