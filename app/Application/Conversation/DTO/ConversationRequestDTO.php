<?php

declare(strict_types=1);

namespace App\Application\Conversation\DTO;

use App\Infrastructure\Currency\Currency;

class ConversationRequestDTO
{
    private Currency $currencyFrom;
    private Currency $currencyTo;
    private float $conversationAmount;

    /**
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param float $conversationAmount
     */
    public function __construct(
        Currency $currencyFrom,
        Currency $currencyTo,
        float $conversationAmount
    ) {
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->conversationAmount = $conversationAmount;
    }

    /**
     * @return Currency
     */
    public function getCurrencyFrom(): Currency
    {
        return $this->currencyFrom;
    }

    /**
     * @return Currency
     */
    public function getCurrencyTo(): Currency
    {
        return $this->currencyTo;
    }

    /**
     * @return float
     */
    public function getConversationAmount(): float
    {
        return $this->conversationAmount;
    }
}
