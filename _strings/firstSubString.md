---
title: Strings\firstSubString()
description: >
 Creates a function which allows for finding the first instance of a substring in  string. Can then return all chars after or before the first occurrence. Can be set to be case sensitive or insensitive. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]
coreFunctions: 
    - strstr()
    - stristr()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L662
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $needle The substring to look for.
   * @param int $flags Possible flags below.
   * @return Closure(string):string
   */
 Strings\firstSubString(string $needle, int $flags = STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE): Closure
closure: >
 /**
  * @param string $haystack The haystack to look through.
  * @return string
  */
 $function (string $haystack): string

examplePartial: >
 // Create a closure which can get all text before foo and one that gets all text after foo.

 $beforeFoo = Strings\firstSubString('foo', STRINGS_BEFORE_NEEDLE);

 $afterFoo = Strings\firstSubString('foo', STRINGS_AFTER_NEEDLE);

 
 // Called as a function.

 echo $beforeFoo('This is when the foo begins'); // 'This is when the '

 echo $afterFoo('This is when the foo begins'); // ' begins'


 // Used in a higher order function.

 $array = array_map($beforeFoo, ['This is when the foo begins', 'not foo']);

 print_r($array); // ['This is when the ', 'not ']



 // Case insensitive can be set by passing the flag.

 $beforeFoo = Strings\firstSubString('foo', STRINGS_BEFORE_NEEDLE | STRINGS_CASE_INSENSITIVE);

 echo $beforeFoo('This is when the Foo begins'); // 'This is when the '

exampleCurried: >
 echo Strings\firstSubString('foo', STRINGS_BEFORE_NEEDLE)('This is when the foo begins'); // 'This is when the '


exampleInline: >
 $array = array_map(
  Strings\firstSubString('foo', STRINGS_BEFORE_NEEDLE), 
  ['This is when the foo begins', 'not foo']
 );

 print_r($array); // ['This is when the ', 'not ']

---
You can use the following constants to define the mode of the function:


- <code class="inline">STRINGS_CASE_INSENSITIVE</code> :: Denotes if the search should be case insensitive.
- <code class="inline">STRINGS_CASE_SENSITIVE</code> :: Denotes if the search should be case sensitive.


- <code class="inline">STRINGS_AFTER_NEEDLE</code> :: Denotes if the returned string should be after the needle.
- <code class="inline">STRINGS_BEFORE_NEEDLE</code> :: Denotes if the returned string should be before the needle.
