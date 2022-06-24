---
layout: function
title: Strings\wrap()
subtitle: Creates a pure function that wraps a string with defined values.
group: strings
subgroup: string_manipulation
definition: >

 /**
   * @param string       $opening Added to the start of the string (and end, if no $closing supplied)
   * @param string|null  $closing Added to the end of the string (optional)
   * @return Closure(string):string
   */
  Strings\wrap(string $opening, ?string $closing = null ): Closure
closure: >
 /**
   * @param string $toWrap  The string to be wrapped
   * @return string         The wrapped string
   * @psalm-pure
   */ 
 $function(string $toWrap): string

---

`wrap()` allows you to create a function which wraps any passed string with opening and closing strings.

### Examples

{% include partials/as-closure.md %}

```php
$makeSpan = Strings\wrap('<span>', '</span>');
echo $makeSpan('Hello'); // <span>Hello</span>
```

{% include partials/as-curried.md %}
    
```php
echo Strings\wrap('##')('Hello'); // ##Hello##
```

{% include partials/for-higher-order.md %}


```php
$array = array_map
    Strings\wrap('<p>', '</p>'), 
    ['Hello', 'World']
);
print_r($array); // [<p>Hello</p>, <p>World</p>]
```