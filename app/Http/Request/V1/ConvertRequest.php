<?php

declare(strict_types=1);

namespace App\Http\Request\V1;

use App\Application\Conversation\DTO\ConversationRequestDTO;
use App\Infrastructure\Currency\Currency;
use Currency\InvalidCurrencyException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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

    /**
     * @return ConversationRequestDTO
     * @throws InvalidCurrencyException
     */
    public function getConversationRequestDTO(): ConversationRequestDTO
    {
        $currencyFrom = new Currency($this->post('currency_from'));
        $currencyTo = new Currency($this->post('currency_to'));

        if ($currencyFrom->getCode() === $currencyTo->getCode()) {
            throw new BadRequestHttpException('Cannot convert in same currency');
        }

        return new ConversationRequestDTO(
            $currencyFrom,
            $currencyTo,
            (float) $this->post('value')
        );
    }
}
