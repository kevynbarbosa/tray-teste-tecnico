<?php

use App\Http\Controllers\ImportOfferController;
use App\Services\ApiMarketPlaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/import-offers', [ImportOfferController::class, 'importOffers'])
    ->name('import-offers');


// Rotas usadas apenas para teste
// Route::get('/pages', function () {
//     $service = new ApiMarketPlaceService;
//     $service->getOffersPage(1);
// });

// Route::get('/details', function () {
//     $service = new ApiMarketPlaceService;
//     $service->getOfferDetails(2024001);
// });

// Route::get('/images', function () {
//     $service = new ApiMarketPlaceService;
//     $service->getOfferImages(2024001);
// });

// Route::get('/prices', function () {
//     $service = new ApiMarketPlaceService;
//     $service->getOfferPrice(2024001);
// });
