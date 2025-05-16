<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/import-offers', function (Request $request) {
    // 1. Verificar quantos anuncios existem
    // 2. Disparar um job para cada pagina disponivel
    // 3. Na model de anuncio, disparar os jobs de imagens e preço
    // 4. Event Listener para conclusao ou erro da importação

    return response()->json(['message' => 'Offers imported successfully']);
});
