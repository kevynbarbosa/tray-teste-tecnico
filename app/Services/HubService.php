<?php

namespace App\Services;

use App\Interfaces\ApiConectorInterface;
use App\Models\Offer;
use GuzzleHttp\Client;

class HubService implements ApiConectorInterface
{
    public Client $client;
    public string $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('API_HUB_BASE_URL');
    }

    public function createOffer(Offer $offer)
    {
        $payload = [
            "title" => $offer->title,
            "description" => $offer->description,
            "status" => $offer->status,
            "stock" => $offer->stock,
        ];

        $response = $this->client->post($this->baseUrl . "/create-offer", [
            'json' => $payload,
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 201) {
            logger()->error("Failed to create offer in HUB. Status code: " . $statusCode);
            // throw new \Exception("Failed to create offer in HUB. Status code: " . $statusCode);
            return false;
        }

        return true;
    }
}
