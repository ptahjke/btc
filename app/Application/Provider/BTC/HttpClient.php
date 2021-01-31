<?php

declare(strict_types=1);

namespace App\Application\Provider\BTC;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClient
{
    // упрощаю до константы
    private const API_URL = 'https://blockchain.info/';

    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(
        Client $client
    ) {
        $this->client = $client;
    }

    /**
     * @param string $endpoint
     * @return array
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function request(string $endpoint): array
    {
        $response = $this->client->request('GET', self::API_URL . $endpoint);
        return (array) json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
