<?php

declare(strict_types=1);

namespace App\Http\Request\V1;

use App\Infrastructure\Currency\Currency;
use Currency\InvalidCurrencyException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class RatesRequest extends V1Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'currency' => ['string'],
        ];
    }

    /**
     * @return Currency|null
     * @throws InvalidCurrencyException
     */
    public function getCurrency(): ?Currency
    {
        $currency = $this->get('currency');
        if ($currency === null) {
            return null;
        }

        return new Currency($this->get('currency'));
    }
}
