---
title: Arrays\filterOr()
description: >
 Create a function which filters an array using multiple predicates, all of which any return true.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L321
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for filtering the passed array using multiple predicates, all of which any return true.
  *
  * @param callable(mixed): bool ...$callable The predicate functions that determines if the value should be kept.
  * @return Closure(array<int|string, mixed>): array<int|string, mixed>
  */
 Arrays\filterOr(callable ...$callback): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create a function that will filter out any number which is a multiple of 3 or 5.

 $filter = Arrays\filterOr(
  fn($v) => $v % 3 === 0,  
  fn($v) => $v % 5 === 0  
 );  


 // Called as a function.

 var_dump($filter([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])); // [3, 5, 6, 9, 10]


exampleCurried: >
 // Filter an array for all even numbers.


 var_dump(Arrays\filterOr('is_numeric', fn($v) => $v % 2 === 0)(['Apple', 2, 3, 4, False, 6])); 
 
 
 // [2, 4, 6]

---