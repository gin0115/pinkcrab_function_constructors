---
layout: composable_function
group: strings
subgroup: string_analysis


title: Strings\countSubString()
description: >
 Allows you to create a function which can be used to count the occurrence of a substring in a string. Allowing for the setting of an optional offset and limit. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L424
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string analysis]
coreFunctions: 
    - substr_count()

deprecated: false
alternative: false

definition: >
 /**
   * @param string $needle The substring to find
   * @param int $offset Place to start, defaults to 0 (start)
   * @param int|null $length Max length after offset to search.
   * @return Closure(string):int
   */
  Strings\countSubString(string $needle, int $offset = 0, ?int $length = null): Closure

closure: >
 /**
   * @param string $haystack 
   * @return int
   * @psalm-pure
   */ 
 $function(string $haystack): int

examplePartial: >
 // Create a closure which will get all instances of IT in a string.

 $countIt = Strings\countSubString('it'); 


 // Create a closure which get all instance of IT after the first 3 letters in a string.

 $countItAfter3 = Strings\countSubString('it', 3);


 // Create a closure which get all instance of IT after the first 10 letters in a string, but only search the first 100 letters.

 $countItBetween10_100 = Strings\countSubString('it', 10, 100);


 // Called as a function.

 echo countIt('This is a string, with it in it'); // 2

 echo countItAfter3('It has it inside it'); // 2


 // Used in a higher order function.

 $array = array_map( $countIt, ['This is a string, with it in it', 'It has it inside it']);

 print_r($array); // [2,3]


exampleCurried: >
 echo Strings\countSubString('it')('It has it inside it'); // 3

 echo Strings\countSubString('it', 3)('It has it inside it'); // 2

exampleInline: >
 $array = array_map( 
   Strings\countSubString('it'), 
   ['This is a string, with it in it', 'It has it inside it']
 );

 print_r($array); // [2,3]
---
