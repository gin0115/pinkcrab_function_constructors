---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\repeat()
subtitle: >
 Allows you to create a function which can be used to repeat a string by a pre defined number. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L535
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - str_repeat()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $count Number of times to repeat string.
   * @return Closure(string):string
   */
  Strings\repeat(int $count): Closure

closure: >
 /**
   * @param string $string The string to repeat
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which can be used to repeat a string 2 times.

 $repeat = Strings\repeat(2);


 // Called as a function.

 echo $repeat('Hello World'); // Hello WorldHello World


 // Used in a higher order function.

 $array = array_map( $hello, ['Once upon time', 'Find the time']);

 print_r($array); // [Once upon timeOnce upon time, Find the timeFind the time]

exampleCurried: >
 echo Strings\repeat(3)('ABC'); //  ABCABCABC

exampleInline: >
 $array = array_map( Strings\repeat(3), ['abcd', 'efgh']);

 print_r($array); // [abcdabcdabcd, efghefghefgh]

---



