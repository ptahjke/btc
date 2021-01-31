<?php

declare(strict_types=1);

namespace App\Application\Rates\DTO;

class RateDTO
{
    private string $currency;
    private float $amount;

    /**
     * @param string $currency
     * @param float $amount
     */
    public function __construct(
        string $currency,
        float $amount
    ) {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
