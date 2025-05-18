<?php

namespace App\States;

use App\Models\Offer;

class OfferCompletedState extends OfferState
{
    public function __construct(public Offer $offer) {}

    public function execute() {}
}
