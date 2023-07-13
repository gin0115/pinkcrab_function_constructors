---
title: Arrays\zip()
description: >
 Creates a function which casts an array to a string using the defined glue.

 <blockquote> Please note all arrays with keys will be converted to an indexed array/list.</blockquote>

layout: function
group: arrays
subgroup: array_transformation
categories: [array, array transformation]
coreFunctions: 

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L180
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for zipping together 2 arrays
  *
  * @param array $additional The Array to zip with
  * @param mixed $default The default value to use if the key does not exist in the additional array.
  * @return Closure(array<int|string, mixed>): array<int|string, mixed>
  */
 Arrays\zip(array $additional, mixed $default = null): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return string
   */
 $function (array $data): string

examplePartial: >
 // Create a closure that zips together 2 arrays with 'FALLBACK' as the default value.
 
 $zip = Arrays\zip(['a', 'b', 'c'], 'FALLBACK');
 

 // Called as a function.  
 
 var_dump($zip(['A', 'B']));   // [['a' , 'A'], ['b', 'B'], ['c', 'FALLBACK']]


exampleCurried: >
 // Zip together 2 arrays with 'FALLBACK' as the default value.

 var_dump(Arrays\zip(['a', 'b', 'c'], 'FALLBACK')(['A', 'B'])); 
 
 // [['a' , 'A'], ['b', 'B'], ['c', 'FALLBACK']]


---