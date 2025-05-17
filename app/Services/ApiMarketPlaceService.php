<?php

namespace App\Services;

use App\Jobs\GetOffersJob;
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

    public function getOffers($page = 1)
    {
        $response = $this->client->get($this->baseUrl . "/offers?page=$page");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offers from API. Status code: " . $statusCode);
        }

        $responseBody = $this->sanitizeResponse($response);

        $arrayResponse = json_decode(trim($responseBody), true);
        $totalPages = $arrayResponse['pagination']['total_pages'];

        for ($i = 1; $i <= $totalPages; $i++) {
            GetOffersJob::dispatch($i);
        }
    }

    public function getOfferDetails($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offer DETAILS from API. Status code: " . $statusCode);
        }
    }

    public function getOfferImages($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/images");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offers IMAGES from API. Status code: " . $statusCode);
        }
    }

    public function getOfferPrice($offerId)
    {
        $response = $this->client->get($this->baseUrl . "/offers/$offerId/prices");

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to fetch offer PRICES from API. Status code: " . $statusCode);
        }
    }
}
