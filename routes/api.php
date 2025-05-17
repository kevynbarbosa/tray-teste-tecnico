<?php

use App\Http\Controllers\ImportOfferController;
use App\Services\ApiMarketPlaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Verificar quantos anuncios existem
// 2. Disparar um job para cada pagina disponivel
// 3. Na model de anuncio, disparar os jobs de imagens e preço
// 4. Event Listener para conclusao ou erro da importação
// 5. Se todas etapas forem concluiodas enviar ao hub
Route::get('/import-offers', [ImportOfferController::class, 'importOffers'])
    ->name('import-offers');


Route::get('/pages', function () {
    $service = new ApiMarketPlaceService;
    $service->getOffersPage(1);
});

Route::get('/details', function () {
    $service = new ApiMarketPlaceService;
    $service->getOfferDetails(2024001);
});

Route::get('/images', function () {
    $service = new ApiMarketPlaceService;
    $service->getOfferImages(2024001);
});

Route::get('/prices', function () {
    $service = new ApiMarketPlaceService;
    $service->getOfferPrice(2024001);
});
