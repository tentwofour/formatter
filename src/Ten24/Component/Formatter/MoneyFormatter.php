<?php

namespace Ten24\Component\Formatter;

class MoneyFormatter
{
    /**
     * @param $dollars
     *
     * @return int
     */
    static public function dollarsToCents($dollars)
    {
        if (!is_float((float) $dollars)) {
            throw new \RuntimeException(
                sprintf('Cannot convert or parse a non-numerical value "%s".', $dollars)
            );
        }

        return $dollars * 100;
    }

    /**
     * @param $cents
     *
     * @return float
     */
    static public function centsToDollars($cents)
    {
        if (!is_numeric($cents)) {
            throw new \RuntimeException(
                sprintf('Cannot parse a non-numerical value "%s".', $cents)
            );
        }

        return number_format((float) $cents / 100, 2);
    }
}