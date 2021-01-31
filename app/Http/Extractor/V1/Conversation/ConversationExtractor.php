<?php

declare(strict_types=1);

namespace App\Http\Extractor\V1\Conversation;

use App\Application\Conversation\DTO\ConversationDTO;

class ConversationExtractor
{
    /**
     * @param ConversationDTO $conversationDTO
     * @return array
     */
    public function extract(ConversationDTO $conversationDTO): array
    {
        return [
            'currency_from' => $conversationDTO->getConversationRequestDTO()->getCurrencyFrom()->getCode(),
            'currency_to' => $conversationDTO->getConversationRequestDTO()->getCurrencyTo()->getCode(),
            'value' => $conversationDTO->getConversationRequestDTO()->getConversationAmount(),
            'converted_value' => $conversationDTO->getConvertedAmount(),
            'rate' => $conversationDTO->getConversationRate(),

        ];
    }
}
