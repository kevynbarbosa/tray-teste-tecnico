<?php

namespace App\Observers;

use App\Enum\OfferImportStatus;
use App\Models\Offer;

class OfferObserver
{
    public function creating(Offer $offer): void
    {
        $offer->workflow_status = OfferImportStatus::PENDING_DETAILS;
    }

    /**
     * Handle the Offer "created" event.
     */
    public function created(Offer $offer): void
    {
        // $offer->workflow_status = OfferImportStatus::PENDING_DETAILS;
    }

    /**
     * Handle the Offer "updated" event.
     */
    public function updated(Offer $offer): void
    {
        //
    }

    /**
     * Handle the Offer "deleted" event.
     */
    public function deleted(Offer $offer): void
    {
        //
    }

    /**
     * Handle the Offer "restored" event.
     */
    public function restored(Offer $offer): void
    {
        //
    }

    /**
     * Handle the Offer "force deleted" event.
     */
    public function forceDeleted(Offer $offer): void
    {
        //
    }
}
