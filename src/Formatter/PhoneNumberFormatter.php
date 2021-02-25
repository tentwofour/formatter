<?php

namespace Ten24\Component\Formatter;

use BadFunctionCallException;

/**
 * Class PhoneNumberFormatter
 *
 * @package Ten24\Component\Formatter
 */
class PhoneNumberFormatter
{
    /**
     * Country code component
     */
    const COUNTRY_CODE = 1;

    /**
     * Area code component
     */
    const AREA_CODE = 2;

    /**
     * Prefix component
     */
    const PREFIX = 4;

    /**
     * Line number component
     */
    const LINE_NUMBER = 16;

    /**
     * Extension delimiter component
     */
    const EXTENSION_DELIMITER = 32;

    /**
     * Extension component
     */
    const EXTENSION = 64;

    /**
     * Common format, North American
     * ie. 1 (306) 555-5555
     */
    const FORMAT_NA = '+%d (%d) %d-%d';

    /**
     * @var string
     *
     * Common format
     * ie. 1.306.555.5555
     */
    const FORMAT_DOTTED = '+%d.%d.%d.%d';

    /**
     * @var string
     *
     * Common format
     * ie. 1-306-555-5555
     */
    const FORMAT_HYPHENATED = '+%d-%d-%d-%d';

    /**
     * The format returned by the getDisplayPhoneNumber
     *
     * @var string
     */
    private $displayFormat;

    /**
     * The phone number
     *
     * @var string
     */
    private $phoneNumber;

    /**
     * The parsed components of the phone number
     *
     * @var array
     */
    private $components;

    /**
     * @var string
     */
    private $format;

    /**
     * Constructor
     *
     * @param string $format
     * @param string $phoneNumber
     */
    public function __construct(string $phoneNumber = '', $format = self::FORMAT_NA)
    {
        $this->format      = $format;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get formatted phone number for display
     * This assumes a flattened format like 11235551234
     *
     * @return string
     */
    public function format()
    {
        if (strlen($this->phoneNumber) >= 7) {
            return sprintf($this->format,
                $this->getCountryCode(),
                $this->getAreaCode(),
                $this->getPrefix(),
                $this->getLineNumber());
        }

        return '';
    }

    /**
     * Builds the flattened phone number for storage
     * This assumes a user-inputted phone number
     * A database string column of length 15 is adequate
     *
     * @return string
     */
    public function reverseFormat(): string
    {
        $pattern = '/[^\+,0-9+]/';

        return preg_replace($pattern, '', $this->phoneNumber);
    }

    /**
     * Get country code component
     *
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->getComponent(self::COUNTRY_CODE);
    }

    /**
     * Get area code component
     *
     * @return string
     */
    public function getAreaCode(): string
    {
        return $this->getComponent(self::AREA_CODE);
    }

    /**
     * Get prefix component
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->getComponent(self::PREFIX);
    }

    /**
     * Get line number component
     *
     * @return string
     */
    public function getLineNumber(): string
    {
        return $this->getComponent(self::LINE_NUMBER);
    }

    /**
     * Get phone number component
     *
     * @param null $component
     *
     * @return string|null
     */
    public function getComponent($component = null)
    {
        if (null === $this->components) {
            $pattern = '/
                (?<countryCode>(\+?\d{1,2})?\D*)         # optional country code
                (?<areaCode>(\d{3})?\D*)                 # optional area code
                (?<prefix>(\d{3})\D*)                    # first three (prefix)
                (?<lineNumber>(\d{4}))                   # last four (line number)
                (?<extensionDelimiter>(?:\D+|$))         # extension delimiter or EOL
                (?<extension>(\d*))                      # optional extension
                /x';

            if (preg_match($pattern, $this->phoneNumber, $matches)) {
                // Matches will be
                // Array
                //(
                // [0] => +11235551234x999
                // [1] => +1
                // [2] => 123
                // [3] => 555
                // [4] => 1234
                // [5] => x
                // [6] => 999
                //)
                $this->components = $matches;
            }
        }

        switch ($component) {
            case self::COUNTRY_CODE:
                return !empty($this->components['countryCode']) ? $this->components['countryCode'] : '+1';
            case self::AREA_CODE:
                return $this->components['areaCode'];
            case self::PREFIX:
                return $this->components['prefix'];
            case self::LINE_NUMBER:
                return $this->components['lineNumber'];
            case self::EXTENSION_DELIMITER:
                return $this->components['extensionDelimiter'];
            case self::EXTENSION:
                return $this->components['extension'];
            default:
                return null;
        }
    }

    /**
     * Get unformatted phone number
     *
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Set unformatted phone number
     *
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber = null)
    {
        $this->phoneNumber = $phoneNumber;
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
     *
     * @throws \BadFunctionCallException
     */
    public function setDisplayFormat($displayFormat = self::FORMAT_NA)
    {
        if (substr_count($displayFormat, '%d') !== 4) {
            throw new BadFunctionCallException('The format passed must be passed in the sprintf() format, and have exactly 4 digit components');
        }

        $this->displayFormat = $displayFormat;
    }
}