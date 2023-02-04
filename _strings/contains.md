---
title: Strings\contains()
subtitle: Returns a function which can be used to check if a string contains a defined sub string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_filter().

layout: function
group: strings
subgroup: string_predicate
coreFunctions: 
    - str_contains()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L234
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $find The value to look for.
   * @return Closure(string):bool
   */
  Strings\contains(string $find): Closure

closure: >
 /**
   * @param string $source
   * @return bool
   * @psalm-pure
   */ 
 $function(string $source): bool

examplePartial: >
 // Create function to check if a string starts with 'foo'

 $containsFoo = Strings\contains('foo');


 // Called as a function.

 $containsFoo('its foo'); // true

 $containsFoo('its bar'); // false


 // Used in a higher order function.

 $array = array_filter(['its foo', 'its bar'], $containsFoo);

 print_r($array); // ['its foo']




exampleCurried: >
 Strings\contains('foo')('its foo'); // true

 Strings\contains('foo')('its bar'); // false


exampleInline: >
  $array = array_filter(['its foo', 'its bar'], Strings\contains('foo'));


  // ['its foo']

---
