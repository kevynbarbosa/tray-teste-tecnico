<?php

namespace App\Interfaces;

use GuzzleHttp\Client;

interface ApiConectorInterface
{
    public string $baseUrl { get; set; }

    public Client $client { get; set; }
}
