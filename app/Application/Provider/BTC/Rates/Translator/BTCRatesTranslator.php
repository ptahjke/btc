<?php

declare(strict_types=1);

namespace App\Application\Provider\BTC\Rates\Translator;

use App\Application\Rates\DTO\RateDTO;

class BTCRatesTranslator
{
    /**
     * @param array $rates
     * @return RateDTO[]
     */
    public function translate(array $rates): array
    {
        $result = [];
        foreach ($rates as $currency => $rate) {
            $result[] = new RateDTO(
                $currency,
                $rate['buy']
            );
        }

        return $result;
    }
}
