---
layout: composable_function
group: strings
subgroup: string_analysis


title: Strings\countChars()
description: >
 Allows you to create a function which can be used to split into groups of specified chunk lengths. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L400
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string analysis]
coreFunctions: 
    - count_chars()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $mode See details below.
   * @return Closure(string):(int[]|string)
   */
  Strings\countChars(int $mode = CHAR_COUNT_ARRAY_KEYED): Closure

closure: >
 /**
   * @param string $string The string to have its char counted.
   * @return int[]|string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will count chars in a string as an array.

 $countToArray = Strings\countChars(CHAR_COUNT_ARRAY); // $mode = 0


 // Create a closure which will count chars in a string as a string.

 $countToString = Strings\countChars(CHAR_COUNT_STRING_UNIQUE); // $mode = 3


 // Called as a function.

 print_r( countToArray('AABBCC')); // [65 => 2, 66 => 2, 67 => 2]

 echo countToString('AABBCC'); // ABC


 // Used in a higher order function.

 $array = array_map( $countToString, ['This is a string', 'Different words']);

 print_r($array); // [' Taghinrst', ' Ddefinorstw']


exampleCurried: >
 echo Strings\countChars(CHAR_COUNT_STRING_UNIQUE)('AABBBBBBBCCC'); // [ABC]

exampleInline: >
 $array = array_map( Strings\countChars(CHAR_COUNT_STRING_UNIQUE), ['This is a string', 'Different words']);

 print_r($array); // [' Taghinrst', ' Ddefinorstw']


 // Can be piped with char() to cast BYTE to string.

 $count = GeneralFunctions\pipe('AABBCC', Strings\countChars(CHAR_COUNT_ARRAY), 'char');

 print_r($count); // [A => 2, B => 2, C => 2]

---

You can use the following constants to define the mode of the function:


- <code class="inline">CHAR_COUNT_ARRAY</code> :: an array with the byte-value as key and the frequency of every byte as value.
- <code class="inline">CHAR_COUNT_ARRAY_UNIQUE</code> :: same as CHAR_COUNT_ARRAY_KEYED but only byte-values with a frequency greater than zero are listed.
- <code class="inline">CHAR_COUNT_ARRAY_UNUSED</code> :: same as CHAR_COUNT_ARRAY_KEYED but only byte-values with a frequency equal to zero are listed.
- <code class="inline">CHAR_COUNT_STRING_UNIQUE</code> :: a string containing all unique characters is returned.
- <code class="inline">CHAR_COUNT_STRING_UNUSED</code> :: a string containing all not used characters is returned.

>> Constants added in V3.0.0