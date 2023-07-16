---
layout: composable_function
group: strings
subgroup: string_analysis


title: Strings\wordCount()
description: >
 Allows you to create a function which can be used to count the number or words in a string. Can be done in various modes with an allowed set of custom word definitions. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L553
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string analysis]
coreFunctions: 
    - str_word_count()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $format can use WORD_COUNT_NUMBER_OF_WORDS | WORD_COUNT_ARRAY | WORD_COUNT_ASSOCIATIVE_ARRAY
   * @param string|null $charList The char list of option values considered words.
   * @return Closure(string):(int|string[])
   */
  Strings\wordCount(int $format = WORD_COUNT_NUMBER_OF_WORDS, ?string $charList = null): Closure

closure: >
 /**
   * @param string $string The string to pad out.
   * @return int|string[]
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will count all words in a string.

 $count = Strings\wordCount(WORD_COUNT_NUMBER_OF_WORDS);


 // Called as a function.

 echo $count('This is a string'); // 4


 // Used in a higher order function.

 $array = array_map( $count, ['This is a string', 'Different words']);

 print_r($array); // [4, 2]


 // Create a closure which will return an array of all words in a string.

 $count = Strings\wordCount(WORD_COUNT_ARRAY);


 // Called as a function.

 echo $count('This is a string with 123456'); // ['This', 'is', 'a', 'string', 'with']


 // Create a closure which can be used to return an array with the word and position in the string.

 $count = Strings\wordCount(WORD_COUNT_ASSOCIATIVE_ARRAY);


 // Called as a function.

 echo $count('This is a string with 123456'); // ['This' => 0, 'is' => 5, 'a' => 8, 'string' => 10, 'with' => 17]



exampleCurried: >
 // You can add additional chars to be treated as part of a word. This even allows numerical ranges.


 print_r(Strings\wordCount(WORD_COUNT_ARRAY, '0..3')('Allow 0 and 1 and 2 and 3 but not 4')); 
 
 // ['Allow', '0', 'and', '1', 'and', '2', 'and', '3', 'but', 'not']
exampleInline: >
 $wordCount = array_map(
  Strings\wordCount(WORD_COUNT_NUMBER_OF_WORDS), 
  ['This is a string', 'Different words 123']
 );

 print_r($wordCount); // [4, 2]

---

You can use the following constants to define the mode of the function:


- <code class="inline">WORD_COUNT_NUMBER_OF_WORDS</code> :: A numerical count of words.
- <code class="inline">WORD_COUNT_ARRAY</code> :: An array of all words in the string.
- <code class="inline">WORD_COUNT_ASSOCIATIVE_ARRAY</code> :: An array of all words with the position in the string as the value.

>> Constants added in V0.1.0