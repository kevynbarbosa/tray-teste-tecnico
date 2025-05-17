<?php

namespace App\Services;

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

    public function createOffer($offerId)
    {
        $payload = [
            "title" => "string",
            "description" => "string",
            "status" => "string",
            "stock" => 999999
        ];

        $response = $this->client->post($this->baseUrl . "/create-offer", [
            'json' => $payload,
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("Failed to create offer in HUB. Status code: " . $statusCode);
        }

        // Atualizar o status do produto
    }
}
