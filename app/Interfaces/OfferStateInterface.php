<?php

namespace App\Interfaces;

use App\Models\Offer;

interface OfferStateInterface
{
    public function __construct(public Offer $offer);

    public function execute();
}
