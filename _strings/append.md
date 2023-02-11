---
title: Strings\append()
subtitle: >
 Allows you to create a function which can be used to append a sub string to a passed string. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

layout: function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L101
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: null

definition: >
 /**
   * @param string $append
   * @return Closure(string):string
   */
  Strings\append(string $append): Closure
closure: >
 /**
   * @param string $toAppendOnto  The string to have the sub string added to
   * @return string                The sliced string
   * @psalm-pure
   */ 
 $function(string $toAppendOnto): string

examplePartial: >
 $appendFoo = Strings\append('foo');


 // Called as a function.

 echo $appendFoo('Hello'); // Hellofoo


 // Used in a higher order function.

 $array = array_map( $appendFoo, ['Hello', 'World']);

 print_r($array); // [Hellofoo, Worldfoo]

exampleCurried: >
 Strings\append('foo')('Bar'); // Barfoo
exampleInline: >
 $array = array_map( Strings\append('foo'), ['Hello', 'World'])


 print_r($array); // [Hellofoo, Worldfoo]

---
