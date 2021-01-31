<?php

declare(strict_types=1);

namespace App\Http\Extractor\V1\Rate;

use App\Application\Rates\DTO\RateDTO;

class RateExtractor
{
    /**
     * @param RateDTO $rateDTO
     * @return array
     */
    public function extract(RateDTO $rateDTO): array
    {
        return [
            $rateDTO->getCurrency() => $rateDTO->getAmount(),
        ];
    }
}
