<?php

namespace App\Http\Controllers;

use App\Services\ApiMarketPlaceService;
use Illuminate\Http\Request;

class ImportOfferController extends Controller
{
    public function importOffers()
    {
        try {
            (new ApiMarketPlaceService())->getOffers();
        } catch (\Throwable $th) {
            logger()->error('Error importing offers: ' . $th->getMessage());
            return response()->json(['message' => 'An error occured while importing offers'], 500);
        }

        return response()->json(['message' => 'Import offers initiated']);
    }
}
