<?php

namespace Ten24\Tests\Component\Formatter;

use PHPUnit\Framework\TestCase;
use Ten24\Component\Formatter\PostalCodeFormatter;

/**
 * Class PostalCodeFormatterTest
 *
 * @package Ten24\Tests\Fomponent\Formatter
 */
class PostalCodeFormatterTest extends TestCase
{
    /**
     * @var \Ten24\Component\Formatter\PostalCodeFormatter
     */
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new PostalCodeFormatter();
    }

    public function testGetSetPostalCode()
    {
        $postalCode = 'S4T0H0';
        $this->formatter->setPostalCode($postalCode);
        self::assertEquals($postalCode, $this->formatter->getPostalCode());
    }

    public function testFormat()
    {
        $this->formatter->setPostalCode('S4T0H0');
        self::assertEquals('S4T 0H0', $this->formatter->format());

        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        $this->formatter->setPostalCode('12345');
        self::assertEquals('12345', $this->formatter->format());
    }

    public function testReverseFormat()
    {
        $this->formatter->setPostalCode('S4T 0H0');
        self::assertEquals('S4T0H0', $this->formatter->reverseFormat());

        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        $this->formatter->setPostalCode('12345');
        self::assertEquals('12345', $this->formatter->format());
    }

    public function testGetSetDisplayFormat()
    {
        self::assertEquals(PostalCodeFormatter::FORMAT_CANADA, $this->formatter->getDisplayFormat());
        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        self::assertEquals(PostalCodeFormatter::FORMAT_USA, $this->formatter->getDisplayFormat());
    }
}