# Formatter Component

## MoneyFormatter

Formats from cents => dollars, and vice-versa. Useful for database storage of monetary values, without needing a decimal column. 

*PHP's Type Juggling deals with string arguments, which may lead to unexpected results.*
 
```php
MoneyFormatter::dollarsToCents(12.00);
// => 1200

MoneyFormatter::dollarsToCents(1200);
// => 12.00
```

## PhoneNumberFormatter

Formats a phone number to a flattened string (eg. no separators of any kind), and back to a human-readable style again.

Current human-readable formats are N/A style (+%d (%d) %d-%d).

Useful for normalizing database stored values and allowing application-varied formatting.

```php
$f = new PhoneNumberFormatter('+14239170989');

$formatted = $f->format()
// => +1 (423) 917-0989

$f->setPhoneNumber($formatted);
$reverse = $f->reverseFormat();
// => +14239170989
```

## PostalCodeFormatter

Formats a postal code to a flattened representation, and back again. Supports US & Canadian postal codes.

Useful for normalizing database stored values and allowing application-varied formatting.

```php
$f = new PostalCodeFormatter('H0H 0H0');

$formatted = $f->format()
// => h0h0h0 

$f->setPostalCode($formatted);
$reverse = $f->reverseFormat();
// => H0H 0H0
```