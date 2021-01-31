<?php

declare(strict_types=1);

namespace App\Domain;

class CommissionCalculator
{
    // для упрощения просто константа
    private const COMMISSION_PERCENT = 0.02;

    /**
     * @param float $amount
     * @return float
     */
    public function calculate(float $amount): float
    {
        return $amount * self::COMMISSION_PERCENT;
    }
}
