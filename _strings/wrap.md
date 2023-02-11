---
title: Strings\wrap()
subtitle: >
 Allows you to create a function which wraps any passed string with opening and closing strings. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

layout: function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#45
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >

 /**
   * @param string       $opening Added to the start of the string (and end, if no $closing supplied)
   * @param string|null  $closing Added to the end of the string (optional)
   * @return Closure(string):string
   */
  Strings\wrap(string $opening, ?string $closing = null ): Closure
closure: >
 /**
   * @param string $toWrap  The string to be wrapped
   * @return string         The wrapped string
   * @psalm-pure
   */ 
 $function(string $toWrap): string


examplePartial: >
 // Create the closure to wrap any string with a <span> tag

 $makeSpan = Strings\wrap('<span>', '</span>');


 // Called as a function.
 
 echo $makeSpan('Hello'); // <span>Hello</span>
 

 // Used in a higher order function.

 $array = array_map( $makeSpan, ['Hello', 'World']);
 
 print_r($array); // [<span>Hello</span>, <span>World</span>]

exampleCurried: >
 echo Strings\wrap('##')('Hello'); // ##Hello##

exampleInline: >
 $array = array_map(
    Strings\wrap('<p>', '</p>'), 
    ['Hello', 'World']
 );

 print_r($array); // [<p>Hello</p>, <p>World</p>] 

---
