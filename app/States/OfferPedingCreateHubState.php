<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Interfaces\OfferStateInterface;
use App\Models\Offer;
use App\Services\HubService;

class OfferPendingCreateHubState implements OfferStateInterface
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new HubService())->createOffer($this->offer);

        if ($success) {
            $this->offer->workflow_status = OfferImportStatus::COMPLETED;
            $this->offer->save();
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_CREATE_HUB;
            $this->offer->save();
        }


        return $success;
    }
}
