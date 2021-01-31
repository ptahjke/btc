<?php

declare(strict_types=1);

namespace App\Application\Provider\BTC\Rates;

use App\Application\Provider\BTC\HttpClient;
use App\Application\Provider\BTC\Rates\Translator\BTCRatesTranslator;
use App\Application\Rates\DTO\RateDTO;
use GuzzleHttp\Exception\GuzzleException;

class BTCRatesProvider
{
    private const API_ENDPOINT_RATES = 'ticker';

    private HttpClient $httpClient;
    private BTCRatesTranslator $btcRatesTranslator;

    /**
     * @param HttpClient $httpClient
     * @param BTCRatesTranslator $btcRatesTranslator
     */
    public function __construct(
        HttpClient $httpClient,
        BTCRatesTranslator $btcRatesTranslator
    ) {
        $this->httpClient = $httpClient;
        $this->btcRatesTranslator = $btcRatesTranslator;
    }

    /**
     * @return RateDTO[]
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function rates(): array
    {
        $result = $this->httpClient->request(self::API_ENDPOINT_RATES);

        return $this->btcRatesTranslator->translate($result);
    }
}
