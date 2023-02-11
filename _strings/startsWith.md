---
title: Strings\startsWith()
subtitle: >
 Returns a function which can be used to check if a string starts with a defined sub string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_filter().

layout: function
group: strings
subgroup: string_predicate
categories: [strings, string_predicate, predicate]
coreFunctions: 
    - str_starts_with()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L197
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $find The value to look for.
   * @return Closure(string):bool
   */
  Strings\startsWith(string $find): Closure

closure: >
 /**
   * @param string $source
   * @return bool
   * @psalm-pure
   */ 
 $function(string $source): bool

examplePartial: >
 // Create function to check if a string starts with 'foo'

 $startsWithFoo = Strings\startsWith('foo');


 // Called as a function.

 echo $startsWithFoo('foo begins'); // true


 // Used in a higher order function.

 $array = array_filter(['foo begins', 'not foo'], $startsWithFoo);

 print_r($array); // ['foo begins']




exampleCurried: >
 Strings\startsWith('foo')('foo begins'); // true

 Strings\startsWith('foo')('not foo'); // false


exampleInline: >
  $array = array_filter(['foo begins', 'not foo'], Strings\startsWith('foo'));


  // ['foo begins']

---
