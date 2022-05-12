# Strings

## Setup

## wrap( string $opening, ?string $closing = null ): Closure
> @param string $opening The opening item to wrap with  
> @param string $closing The closing item to wrap with, opening used if null  is passed
> @return Closure(string $string): string Returns a closure that wraps the passed string  

```php
// Create function to wrap any string with ## 
$wrapper = Str\wrap('##');

$string = $wrapper('I am a string');
echo $string; // ##I am a string##

// Wrap all in array of strings.
$string = array_map($wrapper, ['string1', 'string2','string3']);
var_dump($string); // ['##string1##', '##string2##','##string3##']

