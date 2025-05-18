<?php

namespace App\States;

use App\Models\Offer;

abstract class OfferState
{
    protected Offer $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    abstract public function execute();
}
