<?php

declare(strict_types=1);

namespace App\Application\Conversation\DTO;

class ConversationDTO
{
    private ConversationRequestDTO $conversationRequestDTO;
    private float $convertedAmount;
    private float $conversationRate;

    /**
     * @param ConversationRequestDTO $conversationRequestDTO
     * @param float $convertedAmount
     * @param float $conversationRate
     */
    public function __construct(
        ConversationRequestDTO $conversationRequestDTO,
        float $convertedAmount,
        float $conversationRate
    ) {
        $this->conversationRequestDTO = $conversationRequestDTO;
        $this->convertedAmount = $convertedAmount;
        $this->conversationRate = $conversationRate;
    }

    /**
     * @return ConversationRequestDTO
     */
    public function getConversationRequestDTO(): ConversationRequestDTO
    {
        return $this->conversationRequestDTO;
    }

    /**
     * @return float
     */
    public function getConvertedAmount(): float
    {
        return $this->convertedAmount;
    }

    /**
     * @return float
     */
    public function getConversationRate(): float
    {
        return $this->conversationRate;
    }
}
