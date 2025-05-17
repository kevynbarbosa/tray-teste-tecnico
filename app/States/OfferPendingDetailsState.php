<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Interfaces\OfferStateInterface;
use App\Jobs\GetOfferImagesJob;
use App\Models\Offer;
use App\Services\ApiMarketPlaceService;

class OfferPendingDetailsState implements OfferStateInterface
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new ApiMarketPlaceService())->getOfferDetails($this->offer->id);

        if ($success) {
            $this->offer->workflow_status = OfferImportStatus::PENDING_IMAGES;
            $this->offer->save();
            GetOfferImagesJob::dispatch($this->offer);
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_DETAILS;
            $this->offer->save();
        }


        return $success;
    }
}
