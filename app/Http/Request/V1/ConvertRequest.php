<?php

declare(strict_types=1);

namespace App\Http\Request\V1;

use App\Application\Conversation\DTO\ConversationRequestDTO;
use App\Infrastructure\Currency\Currency;
use Currency\InvalidCurrencyException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConvertRequest extends V1Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'currency_from' => ['required', 'string'],
            'currency_to' => ['required', 'string'],
            'value' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function validateResolved()
    {
        $currencyFrom = new Currency($this->post('currency_from'));
        $currencyTo = new Currency($this->post('currency_to'));

        if ($currencyFrom->getCode() === $currencyTo->getCode()) {
            throw new BadRequestHttpException('Cannot convert in same currency');
        }

        if ($currencyFrom->getCode() !== Currency::CURRENCY_BTC
            && $currencyTo->getCode() !== Currency::CURRENCY_BTC) {
            throw new BadRequestHttpException('BTC must be present in from or to currency parameter');
        }
    }

    /**
     * @return ConversationRequestDTO
     * @throws InvalidCurrencyException
     */
    public function getConversationRequestDTO(): ConversationRequestDTO
    {
        return new ConversationRequestDTO(
            new Currency($this->post('currency_from')),
            new Currency($this->post('currency_to')),
            (float) $this->post('value')
        );
    }
}
