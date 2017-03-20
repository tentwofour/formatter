<?php

namespace Ten24\Tests\Fomponent\Formatter;

use PHPUnit\Framework\TestCase;
use Ten24\Component\Formatter\MoneyFormatter;

/**
 * Class MoneyFormatterTest
 *
 * @package Ten24\UtilitiesBundle\Tests\Formatter
 */
class MoneyFormatterTest extends TestCase
{
    public function testDollarsToCents()
    {
        $res = MoneyFormatter::dollarsToCents(12.00);
        self::assertEquals(1200, $res);
    }

    public function testDollarsToCentsWithNonNumerical()
    {
        /** @see http://us2.php.net/manual/en/language.types.string.php#language.types.string.conversion */
        $value = 'I am NOT a number';
        $res = MoneyFormatter::dollarsToCents($value);
        self::assertEquals(0, $res);
    }

    public function testCentsToDollars()
    {
        $res = MoneyFormatter::centsToDollars(1200);
        self::assertEquals(12.00, $res);
    }

    public function testCentsToDollarsWithNonNumerical()
    {
        $value = 'I am NOT a number';

        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Cannot parse a non-numerical value "'.$value.'".');

        MoneyFormatter::centsToDollars($value);
    }
}