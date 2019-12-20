<?php

namespace Ten24\Tests\Component\Formatter;

use PHPUnit\Framework\TestCase;
use Ten24\Component\Formatter\MoneyFormatter;
use TypeError;

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
        $value = 'I am NOT a number';
        $this->expectException(TypeError::class);
        self::expectExceptionMessageRegExp('/must be of the type float, string given/');

        MoneyFormatter::dollarsToCents($value);
    }

    public function testCentsToDollars()
    {
        $res = MoneyFormatter::centsToDollars(1200);
        self::assertEquals(12.00, $res);
    }

    public function testCentsToDollarsWithNonNumerical()
    {
        $value = 'I am NOT a number';

        self::expectException(TypeError::class);
        self::expectExceptionMessageRegExp('/must be of the type integer, string given/');

        MoneyFormatter::centsToDollars($value);
    }
}