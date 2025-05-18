<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Interfaces\OfferStateInterface;
use App\Jobs\GetOfferPriceJob;
use App\Models\Offer;
use App\Services\ApiMarketPlaceService;

class OfferPendingImagesState extends OfferState
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new ApiMarketPlaceService())->getOfferImages($this->offer->id);

        if ($success) {
            $this->offer->workflow_status = OfferImportStatus::PENDING_PRICE;
            $this->offer->save();
            GetOfferPriceJob::dispatch($this->offer);
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_IMAGES;
            $this->offer->save();
        }


        return $success;
    }
}
