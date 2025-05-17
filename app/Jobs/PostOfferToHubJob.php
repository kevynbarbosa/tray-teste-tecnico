<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Services\HubService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PostOfferToHubJob implements ShouldQueue
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
        (new HubService())->createOffer($this->offer);
    }
}
