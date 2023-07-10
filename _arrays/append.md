---
title: Arrays\append()
description: >
 Creates a function which adds the defined values to the end of an array.

layout: function
group: arrays
subgroup: array_manipulation
categories: [arrayss, arrays manipulation]
coreFunctions: 
    - array_push()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L43
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.3.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for appending a value to an array.
  *
  * @param mixed $value
  * @return Closure(array<int|string, mixed>):array<int|string, mixed>
  */
 Arrays\append(mixed $charList): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create the closure that adds 'a' to the end of an array.

 $addA = Arrays\append('a');


 // Called as a function.

 var_dump($addA(['b', 'c'])); // ['b', 'c', 'a']



exampleCurried: >
 // Adds `a` to the end of an array

  var_dump(Arrays\append('a')(['b', 'c'])); // ['b', 'c', 'a']


---