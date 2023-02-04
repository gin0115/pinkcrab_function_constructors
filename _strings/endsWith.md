---
title: Strings\endsWith()
subtitle: Returns a function which can be used to check if a string ends with a defined sub string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_filter().

layout: function
group: strings
subgroup: string_predicate
categories: [strings, string_predicate, predicate]
coreFunctions: 
    - str_ends_with()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L214
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $find The value to look for.
   * @return Closure(string):bool
   */
  Strings\endsWith(string $find): Closure

closure: >
 /**
   * @param string $source
   * @return bool
   * @psalm-pure
   */ 
 $function(string $source): bool

examplePartial: >
 // Create function to check if a string starts with 'foo'

 $endsWithFoo = Strings\endsWith('foo');


 // Called as a function.

 $endsWithFoo('ends foo'); // true

 $endsWithFoo('foo not at end'); // false


 // Used in a higher order function.

 $array = array_filter(['ends foo', 'foo not at end'], $endsWithFoo);

 print_r($array); // ['ends foo']




exampleCurried: >
 Strings\endsWith('foo')('ends foo'); // true

 Strings\endsWith('foo')('foo not at end'); // false


exampleInline: >
  $array = array_filter(['ends foo', 'foo not at end'], Strings\endsWith('foo'));


  // ['ends foo']

---
