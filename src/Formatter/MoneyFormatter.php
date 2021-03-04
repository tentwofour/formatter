<?php

namespace Ten24\Component\Formatter;

use RuntimeException;

class MoneyFormatter
{
    /**
     * @param float $dollars
     *
     * @return int
     */
    static public function dollarsToCents(float $dollars): int
    {
        return $dollars * 100;
    }

    /**
     * @param int $cents
     *
     * @return float
     */
    static public function centsToDollars(int $cents): float
    {
        return (float) sprintf('%.2f', ($cents / 100));
    }
}