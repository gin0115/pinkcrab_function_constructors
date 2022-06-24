---
layout: function
title: Strings\wrap()
subtitle: Allows you to create a function which wraps any passed string with opening and closing strings. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
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