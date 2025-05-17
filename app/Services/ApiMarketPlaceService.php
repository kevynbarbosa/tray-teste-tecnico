<?php

namespace App\Services;

use App\Jobs\GetOfferDetailJob;
use App\Jobs\GetOffersPageJob;
use App\Models\Offer;
use App\Models\OfferImage;
use GuzzleHttp\Client;

class ApiMarketPlaceService
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

        return $response;
    }

    public function getOffers()
    {
        $response = $this->client->get($this->baseUrl . "/offers?page=1");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offers from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);

        $arrayResponse = json_decode(trim($responseBody), true);
        $totalPages = $arrayResponse['pagination']['total_pages'];

        for ($i = 1; $i <= $totalPages; $i++) {
            GetOffersPageJob::dispatch($i);
        }
    }

    public function getOffersPage($page)
    {
        $response = $this->client->get($this->baseUrl . "/offers?page=$page");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offers from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);
        $arrayResponse = json_decode($responseBody, true);

        $offers = $arrayResponse['data']['offers'];
        foreach ($offers as $offerId) {
            GetOfferDetailJob::dispatch($offerId);
        }
    }

    public function getOfferDetails($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offer DETAILS from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);
        $arrayResponse = json_decode($responseBody, true);

        Offer::updateOrCreate(
            ['id' => $offerId],
            $arrayResponse['data']
        );
    }

    public function getOfferImages($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/images");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offers IMAGES from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);
        $arrayResponse = json_decode($responseBody, true);

        foreach ($arrayResponse['data']['images'] as $offerImage) {

            OfferImage::updateOrCreate(
                [
                    'offer_id' => $offerId,
                    'url' => $offerImage['url']
                ],
            );
        }
    }

    public function getOfferPrice($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/prices");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offer PRICES from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);
        $arrayResponse = json_decode($responseBody, true);

        Offer::updateOrCreate(
            ['id' => $offerId],
            [
                'price' => $arrayResponse['data']['price'],
            ]
        );
    }
}
