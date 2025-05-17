<?php

namespace App\Services;

use App\Interfaces\ApiConectorInterface;
use App\Jobs\GetOfferDetailJob;
use App\Jobs\GetOffersPageJob;
use App\Models\Offer;
use App\Models\OfferImage;
use GuzzleHttp\Client;

class ApiMarketPlaceService implements ApiConectorInterface
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('API_MARKETPLACE_BASE_URL');
    }

    private function sanitizeResponse($response)
    {
        $response = $response->getBody()->getContents();
        $response = trim($response);
        $response = preg_replace('/\s+/', ' ', $response);
        $response = json_decode($response, true);

        return $response;
    }

    public function getOffers()
    {
        $response = $this->client->get($this->baseUrl . "/offers?page=1");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            logger()->error("Failed to fetch offers from API. Status code: " . $statusCode);
            // throw new \Exception("Failed to fetch offers from API. Status code: " . $statusCode);
            return false;
        }

        $responseArray = $this->sanitizeResponse($response);
        $totalPages = $responseArray['pagination']['total_pages'];

        for ($i = 1; $i <= $totalPages; $i++) {
            GetOffersPageJob::dispatch($i);
        }

        return true;
    }

    public function getOffersPage(int $page)
    {
        $response = $this->client->get($this->baseUrl . "/offers?page=$page");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            logger()->error("Failed to fetch offers from API. Status code: " . $statusCode);
            // throw new \Exception("Failed to fetch offers from API. Status code: " . $statusCode);
        }

        $responseArray = $this->sanitizeResponse($response);

        $offers = $responseArray['data']['offers'];
        foreach ($offers as $offerId) {
            // Poderiamos disparar jobs para cada anuncio já para atualizar imagens e preço, mas será realizado de forma sequencial
            // Apenas o job de detalhes será disparado
            // E posteriormente os demais jobs

            $offer = Offer::updateOrCreate(
                ['id' => $offerId],
            );
            GetOfferDetailJob::dispatch($offer);
        }
    }

    public function getOfferDetails($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            logger()->error("Failed to fetch offer DETAILS from API. Status code: " . $statusCode);
            // throw new \Exception("Failed to fetch offer DETAILS from API. Status code: " . $statusCode);
            return false;
        }

        $responseArray = $this->sanitizeResponse($response);


        Offer::updateOrCreate(
            ['id' => $offerId],
            $responseArray['data']
        );

        return true;
    }

    public function getOfferImages($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/images");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            // throw new \Exception("Failed to fetch offers IMAGES from API. Status code: " . $statusCode);
            logger()->error("Failed to fetch offers IMAGES from API. Status code: " . $statusCode);
            return false;
        }

        $responseArray = $this->sanitizeResponse($response);


        foreach ($responseArray['data']['images'] as $offerImage) {

            OfferImage::updateOrCreate(
                [
                    'offer_id' => $offerId,
                    'url' => $offerImage['url']
                ],
            );
        }

        return true;
    }

    public function getOfferPrice($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/prices");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            logger()->error("Failed to fetch offer PRICES from API. Status code: " . $statusCode);
            // throw new \Exception("Failed to fetch offer PRICES from API. Status code: " . $statusCode);
            return false;
        }

        $responseArray = $this->sanitizeResponse($response);

        Offer::updateOrCreate(
            ['id' => $offerId],
            [
                'price' => $responseArray['data']['price'],
            ]
        );

        return true;
    }
}
