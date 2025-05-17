<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Interfaces\OfferStateInterface;
use App\Jobs\PostOfferToHubJob;
use App\Models\Offer;
use App\Services\ApiMarketPlaceService;

class OfferPendingPriceState implements OfferStateInterface
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new ApiMarketPlaceService())->getOfferPrice($this->offer->id);

        if ($success) {
            $this->offer->workflow_status = OfferImportStatus::PENDING_CREATE_HUB;
            $this->offer->save();
            PostOfferToHubJob::dispatch($this->offer);
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_PRICE;
            $this->offer->save();
        }


        return $success;
    }
}
