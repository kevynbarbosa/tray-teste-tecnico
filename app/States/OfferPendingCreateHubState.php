<?php

namespace App\States;

use App\Enum\OfferImportStatus;
use App\Models\Offer;
use App\Services\HubService;

class OfferPendingCreateHubState extends OfferState
{
    public function __construct(public Offer $offer) {}

    public function execute()
    {
        $success = (new HubService())->createOffer($this->offer);

        if ($success) {
            $this->offer->workflow_status = OfferImportStatus::COMPLETED;
            $this->offer->setState(new OfferCompletedState($this->offer));
            $this->offer->save();
        } else {
            $this->offer->workflow_status = OfferImportStatus::ERROR_CREATE_HUB;
            $this->offer->save();
        }

        return $success;
    }
}
