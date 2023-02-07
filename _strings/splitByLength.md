---
layout: function
group: strings
subgroup: string_transform


title: Strings\splitByLength()
subtitle: Allows you to create a function which can be used to split into groups of specified chunk lengths. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L344
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string transform]
coreFunctions: 
    - str_split()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $length The length to split the string up with.
   * @return Closure(string):array<string> The parts.
   */
  Strings\splitByLength(int $length): Closure

closure: >
 /**
   * @param string $string The string to be split
   * @return array<int, string>
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will take the first 2 characters of a string.

 $splitIn2 = Strings\splitByLength(2);  


 // Called as a function.

 echo $splitIn2('AABBCC'); // [AA, BB, CC]


 // Used in a higher order function.

 $array = array_map( $splitIn2, ['045678941212', '123456789012']);

 print_r($array); // [[04,56,78,94,12,12], [12,34,56,78,90,12]]


exampleCurried: >
 echo Strings\splitByLength(2)('AABBCC'); // [AA, BB, CC]

exampleInline: >
 $array = array_map( Strings\splitByLength(4), ['045678941212', '123456789012']);

 print_r($array); // [[0456,7894,1212], [1234,5678,9012]]

---



