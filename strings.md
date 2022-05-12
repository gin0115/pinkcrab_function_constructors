# wrap( string $opening, ?string $closing = null ): Closure

Creates a closure that can be used to wrap a string with a definable opening and closing val
ues.  
   
> `@param string $opening The opening item to wrap with`   
> `@param string $closing The closing item to wrap with, opening used if null is passed`   
> `@return Closure(string $string): string Returns a closure that wraps the passed string`      
   
```php
// Create function to wrap any string with ## 
$wrapper = Str\wrap('##');

// Wrap a single string
$string = $wrapper('I am a string');
echo $string; // ##I am a string##

// Wrap all in array of strings.
$string = array_map($wrapper, ['string1', 'string2','string3']);
var_dump($string); // ['##string1##', '##string2##','##string3##']
```

***

# tagWrap( string $openingTag, ?string $closing = null ): Closure

Creates a closure that can be used to wrap a string with a definable opening and closing tag.
   
> `@param string $openingTag The opening tag token to wrap with`   
> `@param string $closing The closing tag token to wrap with, opening used if null is passed`   
> `@return Closure(string $string): string Returns a closure that wraps the passed string`      
   
```php
// Create function to wrap any string with ## 
$wrapper = Str\tagWrap('div class="foo"', 'div');

// Wrap a single string
$string = $wrapper('I am a string');
echo $string; // <div class="foo">I am a string</div>

// Wrap all in array of strings.
$string = array_map($wrapper, ['string1', 'string2','string3']);
var_dump($string); // ['<div class="foo">string1</div>', '<div class="foo">string2<...']
```

***