---
title: Strings\lastPosition()
description: >
 Returns a function which can be used to find the last position of a defined sub string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_filter().

layout: function
group: strings
subgroup: string_analysis
categories: [strings, string_analysis]
coreFunctions: 
    - strpos()
    - stripos()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L613
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $needle The value to look for.
   * @param int  $offset The offset to start
   * @param int $flags STRINGS_CASE_SENSITIVE | STRINGS_CASE_INSENSITIVE
   * @return Closure(string):?int
   */
 Strings\lastPosition(string $needle, int $offset = 0, int $flags = STRINGS_CASE_SENSITIVE): Closure

closure: >
 /**
   * @param string $source
   * @return bool
   * @psalm-pure
   */ 
 $function(string $source): bool

examplePartial: >
 // Create function to find the first position of 'foo'

 $lastPositionOfFoo = Strings\lastPosition('foo');


 // Called as a function.

 echo $lastPositionOfFoo('This is when the foo begins'); // 17


 // Used in a higher order function.

 $array = array_map($lastPositionOfFoo, ['This is when the foo begins', 'not foo']);

 print_r($array); // [17, null]




 
 // An offset of where to start the search can be passed.

 $lastPositionOfFoo = Strings\lastPosition('a', 5);

 print $lastPositionOfFoo('abcdefghijka'); // 11





 // The search can be case sensitive or insensitive. (SENSITIVE by default)

 $lastPositionOfFoo = Strings\lastPosition('C', 0, STRINGS_CASE_INSENSITIVE);

 print $lastPositionOfFoo('abcdefghijka'); // 2


exampleCurried: >
 print Strings\lastPosition('foo')( 'This is when the foo begins'); // 17


exampleInline: >
  $array = array_map(Strings\lastPosition('foo'), ['This is when the foo begins', 'not foo']);

  print_r($array); // [17, null]

---

You can use the following constants to define the mode of the function:


- <code class="inline">STRINGS_CASE_SENSITIVE</code> :: Looks for the exact string.
- <code class="inline">STRINGS_CASE_INSENSITIVE</code> :: Ignores case when looking for the string.