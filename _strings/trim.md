---
layout: composable_function
group: strings
subgroup: string_manipulation


title: Strings\trim()
description: >
 Allows you to create a function which can be used to trim any matches from a mask. Trims the matching values from the start, end or both. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L443
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - trim()

deprecated: false
alternative: false

definition: >
 /**
   * @param string $mask
   * @return Closure(string):string
   */
  Strings\trim(string $mask = "\t\n\r\0\x0B"): Closure

closure: >
 /**
   * @param string $string The string to be trimmed
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will get all instances of IT in a string.

 $trimStar = Strings\trim('*'); 


 // Called as a function.

 echo $trimStar('*This is a string, with it in it*'); // This is a string, with it in it


 // Used in a higher order function.

 $array = array_map( $trimStar, ['**Hi*****', '***Bye']);

 print_r($array); // ['Hi', 'Bye']


exampleCurried: >
 echo Strings\trim('_')('___This is a string, with it in it___'); // This is a string, with it in it

exampleInline: >
 $array = array_map(Strings\trim('-'), ['--Hi-', '-Bye']);
 
 print_r($array); // ['Hi', 'Bye']
---

Related Functions
<ul>
  <!-- <li><a href="{{ site.url }}/strings/trim">Strings\trim()</a></li> -->
  <li><a href="{{ site.url }}/strings/lTrim">Strings\lTrim()</a></li>
  <li><a href="{{ site.url }}/strings/rTrim">Strings\rTrim()</a></li>
</ul>