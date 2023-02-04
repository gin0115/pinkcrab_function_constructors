---
title: Strings\containsPattern()
subtitle: Returns a function which can be used to check if a string contains a defined regex expression. The created function can then reused over any string, or used as part of a Higher Order Function such as array_filter().

layout: function
group: strings
subgroup: string_predicate
categories: [strings, string_predicate, predicate]
coreFunctions: 
    - preg_match()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L251
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $find The pattern to look for.
   * @return Closure(string):bool
   */
  Strings\containsPattern(string $find): Closure

closure: >
 /**
   * @param string $source
   * @return bool
   * @psalm-pure
   */ 
 $function(string $source): bool

examplePartial: >
 // Create function to check if a string contains 'foo' but not 'bar'

 $containsFooNotBar = Strings\containsPattern('/(?!.*bar)(?=.*foo)^(\w+)$/');


 // Called as a function.

 $containsFooNotBar('its foo'); // true

 $containsFooNotBar('its bar'); // false

 $containsFooNotBar('its bar and foo'); // false


 // Used in a higher order function.

 $array = array_filter(['its foo', 'its bar'], $containsFooNotBar);

 print_r($array); // ['its foo']




exampleCurried: >
 Strings\containsPattern('/(?!.*bar)(?=.*foo)^(\w+)$/')('its foo'); // true

 Strings\containsPattern('/(?!.*bar)(?=.*foo)^(\w+)$/')('its bar'); // false

 Strings\containsPattern('/(?!.*bar)(?=.*foo)^(\w+)$/')('its bar and foo'); // false


exampleInline: >
  $array = array_filter(['its foo', 'its bar'], Strings\containsPattern('/(?!.*bar)(?=.*foo)^(\w+)$/'));


  print_r($array); // ['its foo']

---
