<?php

namespace Ten24\Tests\Fomponent\Formatter;

use Ten24\Component\Formatter\PostalCodeFormatter;

/**
 * Class PostalCodeFormatterTest
 *
 * @package Ten24\Tests\Fomponent\Formatter
 */
class PostalCodeFormatterTest extends \PHPUnit_Framework_TestCase
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
        $this->assertEquals($postalCode, $this->formatter->getPostalCode());
    }

    public function testFormat()
    {
        $this->formatter->setPostalCode('S4T0H0');
        $this->assertEquals('S4T 0H0', $this->formatter->format());

        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        $this->formatter->setPostalCode('12345');
        $this->assertEquals('12345', $this->formatter->format());
    }

    public function testReverseFormat()
    {
        $this->formatter->setPostalCode('S4T 0H0');
        $this->assertEquals('S4T0H0', $this->formatter->reverseFormat());

        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        $this->formatter->setPostalCode('12345');
        $this->assertEquals('12345', $this->formatter->format());
    }

    public function testGetSetDisplayFormat()
    {
        $this->assertEquals(PostalCodeFormatter::FORMAT_CANADA, $this->formatter->getDisplayFormat());
        $this->formatter->setDisplayFormat(PostalCodeFormatter::FORMAT_USA);
        $this->assertEquals(PostalCodeFormatter::FORMAT_USA, $this->formatter->getDisplayFormat());
    }
}