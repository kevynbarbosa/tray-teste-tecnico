<?php

namespace App\Interfaces;

use GuzzleHttp\Client;

interface ApiConectorInterface
{
    private string $baseUrl;

    private Client $client;
}
