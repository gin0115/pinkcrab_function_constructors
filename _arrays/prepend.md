---
title: Arrays\prepend()
description: >
 Creates a function which adds the defined values to the start of an array.

layout: function
group: arrays
subgroup: array_manipulation
categories: [array, array manipulation]
coreFunctions: 
    - array_unshift()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L61
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.3.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for prepending a value to an array.
  *
  * @param mixed $value
  * @return Closure(array<int|string, mixed>):array<int|string, mixed>
  */
 Arrays\prepend(mixed $value): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create the closure that adds 'a' to the start of an array.

 $addA = Arrays\prepend('a');


 // Called as a function.

 var_dump($addA(['b', 'c'])); // ['a', 'b', 'c']



exampleCurried: >
 // Adds `a` to the end of an array

  var_dump(Arrays\prepend('a')(['b', 'c'])); // ['a', 'b', 'c']


---