<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Application\Conversation\BTCConversationService;
use App\Application\Rates\BTCRatesService;
use App\Http\Extractor\V1\Conversation\ConversationExtractor;
use App\Http\Extractor\V1\Rate\RateExtractor;
use App\Http\Request\V1\ConvertRequest;
use App\Http\Request\V1\RatesRequest;
use App\Http\Request\V1\V1Request;
use Currency\InvalidCurrencyException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Laravel\Lumen\Routing\Controller;

/*
 * по ходу кода будет строго указан BTC - в названиях папок/классов и т.п.
 * т.к. не расматривал вариант какого-либо расширения
 */
class Router extends Controller
{
    private const METHOD_RATES = 'rates';
    private const METHOD_CONVERT = 'convert';

    public const AVAILABLE_METHODS = [
        self::METHOD_RATES,
        self::METHOD_CONVERT,
    ];

    /**
     * единственное, что не сделал - это приватные методы для роутов
     * дабы не костылить в текущем подходе
     * так же есть нюанс - у фреймворка есть механизм определения HTTP метода по аргументы
     * и он как раз называеться method
     * с единой точкой входа всегда все не просто
     *
     * @param V1Request $v1Request
     * @return mixed
     */
    public function route(
        V1Request $v1Request
    ) {
        return app()->call([$this, $v1Request->getMethod()]);
    }

    /**
     * @param RatesRequest $ratesRequest
     * @param BTCRatesService $btcRatesService
     * @param RateExtractor $rateExtractor
     * @return array
     * @throws GuzzleException
     * @throws InvalidCurrencyException
     * @throws JsonException
     */
    public function rates(
        RatesRequest $ratesRequest,
        BTCRatesService $btcRatesService,
        RateExtractor $rateExtractor
    ): array {
        $currency = $ratesRequest->getCurrency();
        if ($currency !== null) {
            $rates = [$btcRatesService->rateByCurrency($currency)];
        } else {
            $rates = $btcRatesService->rates();
        }

        // для простоты оставил здесь
        $result = [];
        foreach ($rates as $rate) {
            $result[] = $rateExtractor->extract($rate);
        }

        return $result;
    }

    /**
     * @param ConvertRequest $convertRequest
     * @param BTCConversationService $btcConversationService
     * @param ConversationExtractor $conversationExtractor
     * @return array
     * @throws GuzzleException
     * @throws InvalidCurrencyException
     * @throws JsonException
     */
    public function convert(
        ConvertRequest $convertRequest,
        BTCConversationService $btcConversationService,
        ConversationExtractor $conversationExtractor
    ): array {
        $conversation = $btcConversationService->convert($convertRequest->getConversationRequestDTO());

        return $conversationExtractor->extract($conversation);
    }
}
