<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Interfaces\OfferStateInterface;
use App\Jobs\GetOfferImagesJob;
use App\Models\Offer;
use App\Services\ApiMarketPlaceService;

class OfferPendingDetailsState extends OfferState
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new ApiMarketPlaceService())->getOfferDetails($this->offer->id);

        if ($success) {
            $this->offer->workflow_status = 'PENDING_IMAGES';
            $this->offer->setState(new OfferPendingImagesState($this->offer));
            $this->offer->save();
            GetOfferImagesJob::dispatch($this->offer);
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_DETAILS;
            $this->offer->save();
        }


        return $success;
    }
}
