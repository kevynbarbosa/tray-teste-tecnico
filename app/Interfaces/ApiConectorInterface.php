<?php

namespace App\Interfaces;

use GuzzleHttp\Client;

interface ApiConectorInterface
{
    public string $baseUrl;

    public Client $client;
}
