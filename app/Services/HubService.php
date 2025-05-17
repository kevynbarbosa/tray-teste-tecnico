<?php

namespace App\Services;

use App\Models\Offer;
use GuzzleHttp\Client;

class HubService
{
    protected $client;
    protected $baseUrl;

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
        if ($statusCode !== 200) {
            throw new \Exception("Failed to create offer in HUB. Status code: " . $statusCode);
        }
    }
}
