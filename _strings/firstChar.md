---
title: Strings\firstChar()
description: >
 Returns a function which can be used to get the contents of a string after (and including) the occurrence of a defined char. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_manipulation
categories: [strings, string_manipulation]
coreFunctions: 
    - strpbrk()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L687
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   *  @param string $chars All chars to check with.
   * @return Closure(string):strin
   */
 Strings\firstChar(string $chars): Closure

closure: >
 /**
   * @param string $haystack
   * @return string
   * @psalm-pure
   */ 
 $function(string $haystack): bool

examplePartial: >
 // Create function to get the rest of a string after the first occurrence of either m or i

 $firstMorI = Strings\firstChar('mi');


 // Called as a function.

 $firstMorI('This is a Simple text.'); // 'is is a Simple text.'


 // Used in a higher order function.

 $array = array_map($firstMorI, ['This is a Simple text.', 'That may be a simple text.']);

 print_r($array); // ['is is a Simple text.', 'may be a simple text.']

exampleCurried: >
 print Strings\firstChar('a')('This is a Simple text.'); // 'a Simple text.'


exampleInline: >
 $array = array_map(Strings\firstChar('a'), ['This is a Simple text.', 'That may be a simple text.']);

 print_r($array); // ['a Simple text.', 'a simple text.']

---
