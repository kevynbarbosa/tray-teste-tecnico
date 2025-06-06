<?php

namespace App\States;

use App\Enum\OfferImportStatus;
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
            $this->offer->workflow_status = 'PENDING_PRICE';
            $this->offer->setState(new OfferPendingPriceState($this->offer));
            $this->offer->save();
            GetOfferPriceJob::dispatch($this->offer);
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_IMAGES;
            $this->offer->save();
        }


        return $success;
    }
}
