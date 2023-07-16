---
title: Arrays\filterFirst()
description: >
 Create a function which filters an array but returns only the first value (not as an array)

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L338
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Creates a Closure for running array filter and getting the first value.
  *
  * @param callable $func
  * @return Closure(array<int|string, mixed>):?mixed
  */
 Arrays\filterFirst(callable $callback): Closure
closure: >
 /**
  * @param array<int|string, mixed> $array The array to filter
  * @return mixed|null The first element from the filtered array or null if filter returns empty
  */
 $function (array $data): mixed

examplePartial: >
 // Create a function that will return the first value that is a string.

 $filter = Arrays\filterFirst('is_string');

 // Called as a function.

 var_dump($filter([null, 1, 'b', 2])); // 'b'


exampleCurried: >
 // Return the first value which is a multiple of 3 and 5.

 var_dump(Arrays\filterFirst(fn($v) => $v % 3 === 0 && $v % 5 === 0)  
 
 ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])); 
 // 15

---