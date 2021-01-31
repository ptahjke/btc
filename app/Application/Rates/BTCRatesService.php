<?php

declare(strict_types=1);

namespace App\Application\Rates;

use App\Application\Provider\BTC\Rates\BTCRatesProvider;
use App\Application\Rates\DTO\RateDTO;
use App\Domain\CommissionCalculator;
use App\Infrastructure\Currency\Currency;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BTCRatesService
{
    private BTCRatesProvider $btcRatesProvider;
    private CommissionCalculator $commissionCalculator;

    /**
     * @param BTCRatesProvider $btcRatesProvider
     * @param CommissionCalculator $commissionCalculator
     */
    public function __construct(
        BTCRatesProvider $btcRatesProvider,
        CommissionCalculator $commissionCalculator
    ) {
        $this->btcRatesProvider = $btcRatesProvider;
        $this->commissionCalculator = $commissionCalculator;
    }

    /**
     * @param Currency $currency
     * @return RateDTO
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function rateByCurrency(Currency $currency): RateDTO
    {
        $rates = $this->rates();
        foreach ($rates as $rate) {
            if ($currency->getCode() === $rate->getCurrency()) {
                return $rate;
            }
        }

        throw new UnprocessableEntityHttpException('Rate not found');
    }

    /**
     * @return RateDTO[]
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function rates(): array
    {
        $rates = $this->btcRatesProvider->rates();

        $result = [];
        foreach ($rates as $rate) {
            $result[] = $this->applyCommission($rate);
        }

        return $result;
    }

    /**
     * такой расчет должене находится в слое бизнеслогики, но для упрощения размещу здесь
     * @param RateDTO $rateDTO
     * @return RateDTO
     */
    public function applyCommission(RateDTO $rateDTO): RateDTO
    {
        return new RateDTO(
            $rateDTO->getCurrency(),
            $rateDTO->getAmount() + $this->commissionCalculator->calculate($rateDTO->getAmount())
        );
    }
}
