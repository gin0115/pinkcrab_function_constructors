---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\wordWrap()
description: >
 Allows you to create a function which can be used to break a string with a maximum width, respecting word boundaries. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L382
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - wordwrap()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $width Max width for each "line"
   * @param string $break The string to use to denote the end of line.
   * @param bool $cut If set to true, words are cut at $width, else overflow.
   * @return Closure(string):string
   * @psalm-pure
   */
  Strings\wordWrap(int $width, string $break = "\n", bool $cut = false): Closure

closure: >
 /**
   * @param string $string The string to be chunked
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will chunk a string at 8 characters, with a - as the end, splitting words.

 $wordWrap8DashSplit = Strings\wordWrap(8, '-', true);


 // Create a closure which will chunk a string at 8 characters, with a - as the end, NOT splitting words.

 $wordWrap8DashWithout = Strings\wordWrap(8, '-', false);


 // Called as a function.
 
 echo $wordWrap8DashSplit('Today I dressed my unicorn in preparation for the race.');

 // Today I-dressed-my-unicorn-in-preparat-ion for-the-race.


 echo $wordWrap8DashWithout('Today I dressed my unicorn in preparation for the race.');

 // Today I-dressed-my-unicorn-in-preparation-for the-race.


 // Used in a higher order function.

 $array = array_map( $wordWrap8DashSplit, [
  'Today I dressed my unicorn in preparation for the race.', 
  'Producing random sentences can be helpful in a number of different ways.'
 ]);

 print_r($array); /* [
   Today I-dressed-my-unicorn-in-preparat-ion for-the-race,
   Producin-g random-sentence-s can be-helpful-in a-number-of-differen-t ways.
  ] */




exampleCurried: >
 echo Strings\wordWrap('5', '*', true)('It is such a wonderful day'); // It is*such*a*wonde*rful*day

 echo Strings\wordWrap('5', '*', false)('It is such a wonderful day'); // It is*such*a*wonderful*day

 // false is the cut default, so can be called as Strings\wordWrap('5', '*')




exampleInline: >
 $array = array_map( Strings\wordWrap(8, '-', true), [
  'Today I dressed my unicorn in preparation for the race.', 
  'Producing random sentences can be helpful in a number of different ways.'
 ]);

 print_r($array); /* [
   Today I-dressed-my-unicorn-in-preparat-ion for-the-race,
   Producin-g random-sentence-s can be-helpful-in a-number-of-differen-t ways.
  ] */

---



