<?php

declare(strict_types=1);

namespace App\Application\Conversation;

use App\Application\Conversation\DTO\ConversationDTO;
use App\Application\Conversation\DTO\ConversationRequestDTO;
use App\Application\Rates\BTCRatesService;
use GuzzleHttp\Exception\GuzzleException;

class BTCConversationService
{
    private BTCRatesService $btcRatesService;

    /**
     * @param BTCRatesService $btcRatesService
     */
    public function __construct(
        BTCRatesService $btcRatesService
    ) {
        $this->btcRatesService = $btcRatesService;
    }

    /**
     * Есть проблема точностью при округлении
     * Иногда выводится число с плавающей точкой с указанием мантисы
     * Для этого есть решение использования более точных функций - нужно ставить расширение
     * то для данной задачи оставил стандартные функции
     *
     * @param ConversationRequestDTO $conversationRequestDTO
     * @return ConversationDTO
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function convert(ConversationRequestDTO $conversationRequestDTO): ConversationDTO
    {
        if ($conversationRequestDTO->getCurrencyTo()->isBTC()) {
            return $this->convertToBTC($conversationRequestDTO);
        }

        return $this->convertFromBTC($conversationRequestDTO);
    }

    /**
     * @param ConversationRequestDTO $conversationRequestDTO
     * @return ConversationDTO
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function convertFromBTC(ConversationRequestDTO $conversationRequestDTO): ConversationDTO
    {
        $rate = $this->btcRatesService->rateByCurrency($conversationRequestDTO->getCurrencyTo());
        $precision = $conversationRequestDTO->getCurrencyTo()->getPrecision();
        $convertedAmount = round($rate->getAmount() * $conversationRequestDTO->getConversationAmount(), $precision);

        return new ConversationDTO(
            $conversationRequestDTO,
            $convertedAmount,
            round($rate->getAmount(), $precision)
        );
    }

    /**
     * @param ConversationRequestDTO $conversationRequestDTO
     * @return ConversationDTO
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function convertToBTC(ConversationRequestDTO $conversationRequestDTO): ConversationDTO
    {
        $rate = $this->btcRatesService->rateByCurrency($conversationRequestDTO->getCurrencyFrom());
        $precision = $conversationRequestDTO->getCurrencyTo()->getPrecision();
        $convertedAmount = round($conversationRequestDTO->getConversationAmount() / $rate->getAmount(), $precision);

        return new ConversationDTO(
            $conversationRequestDTO,
            $convertedAmount,
            round(1 / $rate->getAmount(), $precision)
        );
    }
}
