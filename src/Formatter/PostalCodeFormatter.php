<?php

namespace Ten24\Component\Formatter;

/**
 * Class PostalCodeFormatter
 *
 * @package Ten24\Component\Formatter
 */
class PostalCodeFormatter
{
    /**
     * Common format, USA
     * ie. 12345
     */
    const FORMAT_USA = '/(\d{5})/';

    /**
     * Common format, Canada
     * ie. S4P 0H0
     */
    const FORMAT_CANADA = '/(\w{3})(\w{3})/';

    /**
     * The format returned by the getDisplayFormat
     *
     * @var string
     */
    private $displayFormat;

    /**
     * The postal code
     *
     * @var string
     */
    private $postalCode;

    /**
     * Constructor
     *
     * @param string $postalCode
     * @param string      $displayFormat
     *
     */
    public function __construct(string $postalCode = '', string $displayFormat = self::FORMAT_CANADA)
    {
        $this->displayFormat = $displayFormat;
        $this->postalCode    = $postalCode;
    }

    /**
     * Get formatted phone number for display
     * This assumes a flattened format like 12345 or S4P0H0
     *
     * @return string
     */
    public function format(): string
    {
        switch ($this->displayFormat) {
            case self::FORMAT_CANADA:
                if (preg_match($this->displayFormat, $this->postalCode, $matches) && count($matches) === 3) {
                    return strtoupper(sprintf('%s %s', $matches[1], $matches[2]));
                }

                return $this->postalCode;

            case self::FORMAT_USA:
            default:
                return $this->postalCode;
        }
    }

    /**
     * Builds the flattened phone number for storage
     * This assumes a user-inputted phone number
     * A database string column of length 6 is adequate
     *
     * @return string
     */
    public function reverseFormat(): string
    {
        $pattern = '/[^a-z0-9+]/i';

        return strtoupper(preg_replace($pattern, '', $this->postalCode));
    }

    /**
     * Get unformatted postal code
     *
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Set unformatted postal code
     *
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode = null)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gets the current display format
     *
     * @return string
     */
    public function getDisplayFormat(): string
    {
        return $this->displayFormat;
    }

    /**
     * Sets the display format
     *
     * @param string $displayFormat
     */
    public function setDisplayFormat(string $displayFormat = self::FORMAT_CANADA)
    {
        $this->displayFormat = $displayFormat;
    }
}